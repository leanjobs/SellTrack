<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\IncomingStock;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class IncomingStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $userBranchId = Auth::user()->branches_id;
            $search = $request->input('search');

            if($search){
                $incomingStocks = IncomingStock::with('product_detail')
                ->where('branches_id', $userBranchId)
                ->when($search, function ($query, $search) {
                    $query->whereHas('product_detail', function ($q) use ($search) {
                        $q->where('product_name', 'like', '%' . $search . '%');
                    });
                })
                ->latest()
                ->paginate(10);
            }else{
                $incomingStocks = IncomingStock::with('product_detail')->where('branches_id', $userBranchId)->latest()->paginate(10);
            }


            return view('incoming-stocks.incoming-stocks', compact('incomingStocks'));
        }catch(Exception $e){
            Log::info($e->getMessage());

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('incoming-stocks.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $validated = $request->validate([
                'products_id' => 'required|exists:products,id',
                // 'branches_id' => Auth::user()->branches_id,
                'initial_stocks' => 'required|integer',
                // 'current_stocks' => 'same:initial_stocks|required|integer',
                'expired' => 'required|date|after_or_equal:' . Carbon::now()->addDays(3)->toDateString(),
            ]);
            $validated['current_stocks'] = $validated['initial_stocks'];
            $validated['branches_id'] = Auth::user()->branches_id;

            IncomingStock::create($validated);
            return redirect()->route('incoming-stocks.index')->with('success', 'successfully');
        }catch (Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingStock $incomingStock)
    {
        $products = Product::all();
        return view('incoming-stocks.update', compact(['incomingStock', 'products']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncomingStock $incomingStock)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncomingStock $incomingStock)
    {
        try{

            $validated = $request->validate([
                // 'products_id' => 'required|exists:products,id',
                // 'branches_id' => Auth::user()->branches_id,
                'initial_stocks' => 'required|integer',
                // 'current_stocks' => 'same:initial_stocks|required|integer',
                'expired' => 'required|date|after_or_equal:' . Carbon::now()->addDays(3)->toDateString(),
            ]);
            $initialStockDifference = $validated['initial_stocks'] - $incomingStock->initial_stocks;
            $validated['current_stocks'] = $incomingStock->current_stocks + $initialStockDifference;
            $validated['products_id'] = $incomingStock->products_id;
            $validated['branches_id'] = Auth::user()->branches_id;

            $incomingStock->update($validated);

            return redirect()->route('incoming-stocks.index')->with('success', 'successfully');
        }catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomingStock $incomingStock)
    {
        try{
            $incomingStock->delete();
            return redirect()->route('incoming-stocks.index')->with('success', 'Product deleted');
        }catch(Exception $e){
           return redirect()->route('incoming-stocks.index')->with('error', 'Failed to delete product');

        }
    }
}
