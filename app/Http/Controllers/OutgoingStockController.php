<?php

namespace App\Http\Controllers;

use App\Models\OutgoingStock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OutgoingStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $userBranchId = Auth::user()->branches_id;
            $search = $request->input('search');

            $outgoingStocks = OutgoingStock::with(['detail_bill', 'incoming_stock.product_detail'])
                ->whereHas('incoming_stock', function ($query) use ($userBranchId, $search) {
                    $query->where('branches_id', $userBranchId);

                    if ($search) {
                        $query->whereHas('product_detail', function ($q) use ($search) {
                            $q->where('product_name', 'like', '%' . $search . '%');
                        });
                    }
                })
                ->latest()
                ->get();

            $outgoingStocks->load(['detail_bill', 'incoming_stock']);

            return view('outgoing-stocks.outgoing-stocks', compact('outgoingStocks'));
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingStock $outgoingStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingStock $outgoingStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutgoingStock $outgoingStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingStock $outgoingStock)
    {
        //
    }
}
