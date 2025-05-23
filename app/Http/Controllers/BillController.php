<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\DetailBill;
use App\Models\DetailDiscount;
use App\Models\IncomingStock;
use App\Models\OutgoingStock;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userBranchId = Auth::user()->branches_id;
        $bills = Bill::with(['users', 'member', 'payment'])->where('branches_id', $userBranchId)->latest()->paginate(10);
        // $bills->load(['users', 'member', 'payment']);

        return view('bills.bills', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "members_id" => 'nullable|exists:members,id',
            "payment_method" => 'required|in:cash,qr',
            "tax" => "required|numeric",
            "total_price" => "required|numeric",
            "grand_total" => "required|numeric",
            "items" => "required|array",
            "items.*.product_id" => "required|exists:products,id",
            "items.*.discounts_id" => "nullable|exists:discounts,id",
            "items.*.quantity" => "required|numeric",
            "items.*.total_price" => "required|numeric",
        ]);
        $validated['users_id'] = Auth::user()->id;
        $validated['branches_id'] = Auth::user()->branches_id;

        try {
            $userBranchId = Auth::user()->branches_id;
            $detail_bills = [];

            $payment = Payment::create([
                "payment_type" => $validated['payment_method'],
                "status" => $validated['payment_method'] === "cash" ? "succeed" : "waiting",
            ]);

            $bill = Bill::create([
                "members_id" => $validated['members_id'],
                "users_id" => $validated['users_id'],
                "branches_id" => $validated['branches_id'],
                "payments_id" => $payment->id,
                "total_price" => $validated['total_price'],
                "grand_total" => $validated['grand_total'],
                "tax" => $validated['tax'],
            ]);

            $bill->load(['member', 'branch', 'users']);

            foreach ($validated['items'] as $item) {
                $detail_bill = DetailBill::create([
                    "branches_id" => $validated['branches_id'],
                    "bills_id" => $bill->id,
                    "products_id" => $item['product_id'],
                    "total_price" => $item['total_price'],
                    "quantity" => $item['quantity'],
                    "discounts_id" => $item['discounts_id'],
                ]);
                $detail_bill->load(['product', 'discount']);
                $detail_bills[] = $detail_bill;
                $incoming_stocks = IncomingStock::where("products_id", $item['product_id'])->where('branches_id', $userBranchId)->where("current_stocks", '>', 0)->whereDate("expired", ">=", today())->orderBy("expired", 'asc')->get();

                $quantityToDeduct = $item['quantity'];

                foreach ($incoming_stocks as $incoming_stock) {
                    if ($quantityToDeduct <= 0) break;

                    $deduct = min($quantityToDeduct, $incoming_stock->current_stocks);

                    OutgoingStock::create([
                        "incoming_stocks_id" => $incoming_stock->id,
                        "quantity" => $deduct,
                        "detail_bills_id" => $detail_bill->id
                    ]);

                    $quantityToDeduct -= $deduct;
                }
            }

            $orderId = 'ORD-' . Str::uuid();
            $data = [
                'bill' => $bill,
                'detail_bill' => $detail_bills,
                'payment' => $payment,

            ];

            if ($payment->payment_type == "qr") {
                // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = config('midtrans.ServerKey');
                // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                \Midtrans\Config::$isProduction = config('midtrans.isProduction');
                // Set sanitization on (default)
                \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
                // Set 3DS transaction for credit card to true
                \Midtrans\Config::$is3ds = config('midtrans.is3ds');

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $orderId,
                        'gross_amount' => $bill->grand_total,
                    ),
                );

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $payment->order_id = $orderId;
                $payment->snap_token = $snapToken;
                $payment->save();
            }

            return response()->json(['message' => 'successfully', 'data' => $data]);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        try {
            $bill->load(['member', 'branch', 'users', 'payment']);
            $detail_bills = DetailBill::where('bills_id', $bill->id)->latest()->get();
            foreach ($detail_bills as $detail_bill) {
                $detail_bill->load(['product', 'discount']);
            }
            $data = [
                'bill' => $bill,
                'detail_bill' => $detail_bills,
            ];
            return response()->json(['message' => 'successfully', 'data' => $data]);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }

    public function print(Request $request){
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $userBranchId = Auth::user()->branches_id;
        $bills = Bill::with(['users', 'member', 'payment'])->where('branches_id', $userBranchId)->whereBetween('created_at', [$startDate, $endDate])->latest()->get();
        return view('print.print-bills', compact(['bills', 'startDate', 'endDate']));
    }
}
