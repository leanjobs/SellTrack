<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userBranchId = Auth::user()->branches_id;

        $products = Product::with(['product_category', 'incoming_stocks' => function ($query) use ($userBranchId){
            $query->where('branches_id', $userBranchId)->whereDate("expired", ">=", today());
        }])->latest()->get();
        return view('products.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            // dd($request);
            $validated = $request->validate([
                'product_name' => 'string|required',
                'price' => 'numeric|required',
                'categories_id' => 'required|exists:categories,id'
            ]);

             //add product img
             if($request->file('product_img')){
                $validated['product_img'] = $request->file('product_img')->store('product_img');
            }

            $product = Product::create($validated);

            //create product_code
            $product_id = str_pad($product->id, 3, '0', STR_PAD_LEFT);
            $product_date = now()->format('dmY');
            $product_code = "{$product_id}{$product_date}";
            $product->update(['product_code' => $product_code]);

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        }catch(Exception $e){
             dd($e);
            return redirect()->route('products.create')->with('error', 'Failed to create product');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $categories = Category::all();
        return view('products.update', compact(['product', 'categories']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try{
            $validated = $request->validate([
                'product_name' => 'string|required',
                'price' => 'numeric|required',
                'categories_id' => 'required|exists:categories,id'
            ]);

            //add product img
            if($request->file('product_img')){
                $validated['product_img'] = $request->file('product_img')->store('product_img');
            }

            $product->update($validated);

            return redirect()->route('products.index')->with('success', 'Product Updated');
        }catch(Exception $e){
            // dd($e);
           return redirect()->route('products.create')->with('error', 'Failed to update product');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted');
        }catch(Exception $e){
           return redirect()->route('products.index')->with('error', 'Failed to delete product');

        }
    }
}
