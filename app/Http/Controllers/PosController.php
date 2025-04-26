<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DetailDiscount;
use App\Models\Discount;
use App\Models\Member;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PosController extends Controller
{
    public function index()
    {
        $userBranchId = Auth::user()->branches_id;
        $now = Carbon::today();

        $categories = Category::withCount('products')->get();
        $discountedProductCount = Product::whereHas('discounts', function ($query) {
            $query->where('status', "active")->where('type', '!=', 'cheap_redemption')->whereDate('start_date', '<=', Carbon::now())->whereDate('end_date', '>=', Carbon::now());
        })->count();

        $products =  Product::with(['product_category', 'incoming_stocks' => function ($query) use ($userBranchId) {
            $query->where('branches_id', $userBranchId)->whereDate("expired", ">=", today());
        }])->latest()->get();
        $members = Member::all();
        $discounts = Discount::with(['detail_discounts.free_product', 'detail_discounts.product'])
            ->where(function ($query) use ($userBranchId) {
                $query->where('branches_id', $userBranchId)
                    ->orWhere('all_branches', 1);
            })->where('status', 'active')->whereDate('start_date', '<=', $now)->whereDate('end_date', '>=', $now)->latest()->get();
        $productsFilter = Product::with([
            'product_category',
            'incoming_stocks' => function ($query) use ($userBranchId) {
                $query->where('branches_id', $userBranchId);
            },
            'discounts' => function ($query) {
                $today = today();
                Log::info($today);
                $query->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->where('status', "active");
            }
        ])->latest()->get();

        return view('pos-system.index', compact(['products', 'categories', 'members', 'discounts', 'discountedProductCount', 'productsFilter']));
    }

    public function filterProducts(Request $request)
    {
        try {
            $filter = $request->filter;
            $now = Carbon::now();


            $userBranchId = Auth::user()->branches_id;

            if ($filter == "all") {
                $productsFilter = Product::with(['product_category', 'incoming_stocks' => function ($query) use ($userBranchId) {
                    $query->where('branches_id', $userBranchId);
                },   'discounts' => function ($query) use ($now) {
                    $query->where('start_date', '<=', $now)
                        ->where('end_date', '>=', $now)
                        ->where('status', "active");
                }])->latest()->get();
            } else if ($filter == "discount") {
                $productsFilter = Product::with([
                    'product_category',
                    'incoming_stocks' => function ($query) use ($userBranchId) {
                        $query->where('branches_id', $userBranchId);
                    },
                    'discounts'
                ])->whereHas('discounts', function ($query) {
                    $query->where('status', "active")->where('type', '!=', 'cheap_redemption')->whereDate('start_date', '<=', Carbon::now())->whereDate('end_date', '>=', Carbon::now());
                })->latest()->get();
            } else {
                $productsFilter = Product::with(['product_category', 'incoming_stocks' => function ($query) use ($userBranchId) {
                    $query->where('branches_id', $userBranchId);
                },   'discounts' => function ($query) use ($now) {
                    $query->where('start_date', '<=', $now)
                        ->where('end_date', '>=', $now)
                        ->where('status', "active");
                }])->where('categories_id', $filter)->latest()->get();
            }

            return view('components.filtered-products', compact('productsFilter'))->render();
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
