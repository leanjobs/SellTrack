<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\DetailBill;
use App\Models\IncomingStock;
use App\Models\OutgoingStock;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        try {
            Log::info("request bills", $request->all());

            $validated = $request->validate([
                "members_id" => 'nullable|exists:members,id',
                "payment_method" => 'required|in:cash,qr',
                "tax" => "required|numeric",
                "total_price" => "required|numeric",
                "grand_total" => "required|numeric",
                "items" => "required|array",
                "items.*.product_id" => "required|exists:products,id",
                "items.*.discounts_id" => "nullable|exists:discounts,id" ,
                "items.*.quantity" => "required|numeric",
                "items.*.total_price" => "required|numeric",
            ]);
            $validated['users_id'] = Auth::user()->id;
            $validated['branches_id'] = Auth::user()->branches_id;

            $payment = Payment::create([
                "payment_type" => $validated['payment_method'],
                // "order_id" => $validated['order_id']
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

            foreach ($validated['items'] as $item) {
                $detail_bill = DetailBill::create([
                    "branches_id" => $validated['branches_id'],
                    "bills_id" => $bill->id,
                    "products_id" => $item['product_id'],
                    "total_price" => $item['total_price'],
                    "quantity" => $item['quantity'],
                    "discounts_id" => $item['discounts_id'],
                ]);
                Log::info($detail_bill);
                $incoming_stocks = IncomingStock::where("products_id", $item['product_id'])->where("current_stocks", '>', 0)->whereDate("expired", ">=", today())->orderBy("expired", 'asc')->get();

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
            // return redirect()->back()->with('success', 'successfully');
            return response()->json(['message' => 'successfully']);
        } catch (Exception $e) {
            Log::info( $e->getMessage());
            return redirect()->back()->with('error', 'error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        //
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
}
