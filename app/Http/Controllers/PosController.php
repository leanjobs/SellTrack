<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DetailDiscount;
use App\Models\Discount;
use App\Models\Member;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index(){
        $userBranchId = Auth::user()->branches_id;
        $categories = Category::withCount('products')->get();
        $products =  Product::with(['product_category', 'incoming_stocks' => function ($query) use ($userBranchId){
            $query->where('branches_id', $userBranchId)->whereDate("expired", ">=", today());
        }])->latest()->get();
        $members = Member::all();
        $discounts = Discount::with(['detail_discounts.free_product', 'detail_discounts.product'])->where(function ($query) use ($userBranchId){
            $query->where('branches_id', $userBranchId)->orWhere('all_branches', 1);
        })->where('status', 'active')->latest()->get();


        return view('pos-system.index', compact(['products', 'categories', 'members', 'discounts']));
    }

    public function filterProducts(Request $request){
        $category_id = $request->category_id;        $userBranchId = Auth::user()->branches_id;


        // dd($category_id);

        if($category_id == "all"){
            $products = Product::with(['product_category', 'incoming_stocks' => function ($query) use ($userBranchId){
                $query->where('branches_id', $userBranchId);
            }])->latest()->get();
        }else{
            $products = Product::with(['product_category', 'incoming_stocks' => function ($query) use ($userBranchId){
                $query->where('branches_id', $userBranchId); }])->where('categories_id', $category_id)->latest()->get();
        }

        return view('components.filtered-products', compact(['products']))->render();
    }
}
