<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DetailDiscount;
use App\Models\Discount;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $userBranchId = Auth::user()->branches_id;
            $userRole = Auth::user()->role;
            $search = $request->input('search');
            if($search){
                $discounts = Discount::with(['detail_discounts', 'branches'])->where(function ($query) use ($userBranchId, $userRole) {
                    if ($userRole == "super_admin") {
                        $query->where('branches_id', $userBranchId)->orWhere('all_branches', 1);
                    } else {
                        $query->where('branches_id', $userBranchId);
                    }
                })->where('discount_name', 'like', '%' .$search. '%')->where('status', 'active')->latest()->get();
            }else{
                $discounts = Discount::with(['detail_discounts', 'branches'])->where(function ($query) use ($userBranchId, $userRole) {
                    if ($userRole == "super_admin") {
                        $query->where('branches_id', $userBranchId)->orWhere('all_branches', 1);
                    } else {
                        $query->where('branches_id', $userBranchId);
                    }
                })->where('status', 'active')->latest()->get();
            }



            return view('discounts.discounts', compact('discounts'));

        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $productId = $request->product_id ?? null;
        $type = $request->query('type');
        $userBranchId = Auth::user()->branches_id;
        $userRole = Auth::user()->role;
        $products = collect();
        $branches = Branch::where('status', 'active')->latest()->get();

        if ($userRole === 'super_admin') {
            $products = Product::with([
                'product_category',
                'incoming_stocks' => function ($query) use ($userBranchId) {
                    $query->where('current_stocks', '>', 0)
                          ->whereDate('expired', '>=', today());
                }
            ])
            ->whereHas('incoming_stocks', function ($query) use ($userBranchId) {
                $query->where('current_stocks', '>', 0)
                      ->whereDate('expired', '>=', today());
            })
            ->latest()
            ->get();

        } elseif ($userRole === 'admin') {
            $products = Product::with([
                'product_category',
                'incoming_stocks' => function ($query) use ($userBranchId) {
                    $query->where('branches_id', $userBranchId)
                          ->where('current_stocks', '>', 0)
                          ->whereDate('expired', '>=', today());
                }
            ])
            ->whereHas('incoming_stocks', function ($query) use ($userBranchId) {
                $query->where('branches_id', $userBranchId)
                      ->where('current_stocks', '>', 0)
                      ->whereDate('expired', '>=', today());
            })
            ->latest()
            ->get();

        }

        Log::info(['type' => $type, 'productId' => $productId]);

        return view('discounts.create', compact(['type', 'products', 'branches', 'productId']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('requestt', $request->all());
            $userBranchId = Auth::user()->branches_id;
            $userRole = Auth::user()->role;

            $validated = $request->validate([
                'discount_name' => 'required|string',
                'type' => 'required|in:cheap_redemption,percentage_off,buy_x_get_y,member',
                'branches_id' => 'nullable|exists:branches,id',
                'all_branches' => 'boolean',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'status' => 'required|in:active,inactive',
                'products_id' => 'nullable|exists:products,id',
                'min_quantity' => 'nullable|integer',
                'discount_price' => 'nullable|numeric',
                'discount_percentage' => 'nullable|integer',
                'free_products_id' => 'nullable|exists:products,id',
                'quantity_free_products' => 'nullable|integer',
                'min_total_price' => 'nullable|numeric'
            ]);
            Log::info('validated', $validated);

            $check_discount = Discount::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('status', 'active')
            ->where('deleted_at', null)
            ->whereHas('detail_discounts', function ($query) use ($validated) {
                $query->where('products_id', $validated['products_id']);
            })->where(function ($query) use ($userBranchId, $userRole) {
                if ($userRole == "super_admin") {
                    $query->where('branches_id', $userBranchId)
                          ->orWhere('all_branches', 1);
                } else {
                    $query->where('branches_id', $userBranchId);
                }
            })->latest() ->get();
            Log::info($check_discount);
            if ($check_discount->isNotEmpty()) {
                return redirect()->back()->with('error', "One of the products has an active discount.");
            }

            $detail_discount = DetailDiscount::create([
                // 'discounts_id' => $discount->id,
                'products_id' => $validated['products_id'] ?? null,
                'min_quantity' => $validated['min_quantity'] ?? null,
                'discount_price' => $validated['discount_price'] ?? null,
                'discount_percentage' => $validated['discount_percentage'] ?? null,
                'free_products_id' => $validated['free_products_id'] ?? null,
                'quantity_free_products' => $validated['quantity_free_products'] ?? null,
                'min_total_price' => $validated['min_total_price'] ?? null,
            ]);


            $discount = Discount::create([
                'detail_discounts_id' => $detail_discount->id,
                'discount_name' => $validated['discount_name'],
                'type' => $validated['type'],
                'branches_id' => $validated['branches_id'] ?? null,
                'all_branches' => $validated['all_branches'] ?? 0,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => $validated['status'],
            ]);

            return redirect()->route('discounts.index')->with('success', 'Discount created successfully');
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        $userBranchId = Auth::user()->branches_id;
        $userRole = Auth::user()->role;
        $products = collect();
        $branches = Branch::where('status', 'active')->latest()->get();

        if ($userRole === 'super_admin') {
            $products = Product::with([
                'product_category',
                'incoming_stocks'
            ])->latest()->get();
        } elseif ($userRole === 'admin') {
            $products =  Product::with(['product_category', 'incoming_stocks' => function ($query) use ($userBranchId) {
                $query->where('branches_id', $userBranchId)->whereDate("expired", ">=", today());
            }])->latest()->get();
        }

        return view('discounts.update', compact(['discount', 'products', 'branches']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Discount $discount) {}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        try {
            Log::info('requestt', $request->all());
            $validated = $request->validate([
                'discount_name' => 'sometimes|required|string',
                'type' => 'sometimes|required|in:cheap_redemption,percentage_off,buy_x_get_y,member',
                'branches_id' => 'sometimes|nullable|exists:branches,id',
                'all_branches' => 'sometimes|boolean',
                'start_date' => 'sometimes|required|date|after_or_equal:today',
                'end_date' => 'sometimes|required|date|after_or_equal:start_date',
                'status' => 'sometimes|required|in:active,inactive',
                'products_id' => 'sometimes|nullable|exists:products,id',
                'min_quantity' => 'sometimes|nullable|integer',
                'discount_price' => 'sometimes|nullable|numeric',
                'discount_percentage' => 'sometimes|nullable|integer',
                'free_products_id' => 'sometimes|nullable|exists:products,id',
                'quantity_free_products' => 'sometimes|nullable|integer',
                'min_total_price' => 'sometimes|nullable|numeric'
            ]);
            Log::info('validated', $validated);

            $detail_discount = $discount->detailDiscount;
            if($detail_discount){
                $detail_discount->update([
                    // 'discounts_id' => $discount->id,
                    'products_id' => $validated['products_id'] ?? null,
                    'min_quantity' => $validated['min_quantity'] ?? null,
                    'discount_price' => $validated['discount_price'] ?? null,
                    'discount_percentage' => $validated['discount_percentage'] ?? null,
                    'free_products_id' => $validated['free_products_id'] ?? null,
                    'quantity_free_products' => $validated['quantity_free_products'] ?? null,
                    'min_total_price' => $validated['min_total_price'] ?? null,
                ]);
            }



            $discount->update([
                // 'detail_discounts_id' => $detail_discount->id,
                'discount_name' => $validated['discount_name'],
                'type' => $validated['type'],
                'branches_id' => $validated['branches_id'] ?? null,
                'all_branches' => $validated['all_branches'] ?? 0,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => $validated['status'],
            ]);

            return redirect()->route('discounts.index')->with('success', 'Discount created successfully');
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
       try{
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully');
       }catch(Exception $e){
        return redirect()->route('discounts.index')->with('error', 'Discount deleted failed');
       }
    }
}
