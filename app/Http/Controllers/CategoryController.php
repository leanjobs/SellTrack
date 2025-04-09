<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view('categories.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'category_name' => 'string|required'
            ]);
            Category::create($validated);
            return redirect()->route('categories.index')->with('success', 'category created');

        }catch(Exception $e){
            return redirect()->route('categories.index')->with('error', 'failed to create category');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('categories.update', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try{
            $validated = $request->validate([
                'category_name' => 'string|required'
            ]);
            $category->update($validated);
            return redirect()->route('categories.index')->with('success', 'category updated');
        }catch(Exception $e){
            return redirect()->route('categories.index')->with('error',  'failed to update category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try{
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'category deleted');
        }catch(Exception $e){
            return redirect()->route('categories.index')->with('error', 'failed to deleted category');
        }
    }
}
