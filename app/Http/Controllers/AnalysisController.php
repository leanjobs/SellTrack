<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnalysisController extends Controller
{
    public function index(){
        $userBranchId = Auth::user()->branches_id;
        $bills = Bill::with('payment')->where('branches_id', $userBranchId)->latest()->get();
        $products = Product::with(['incoming_stocks.outgoing_stocks'])
            ->get()->map(function ($product) use ($userBranchId) {
                $filteredIncoming = $product->incoming_stocks->filter(function ($incoming) use ($userBranchId) {
                    return $incoming->branches_id == $userBranchId;
                });
                $totalQuantity = $filteredIncoming->flatMap->outgoing_stocks->sum('quantity');
                $product->total_outgoing_quantity = $totalQuantity;
                return $product;
            })
            ->sortByDesc('total_outgoing_quantity')->values();

        return view('analysis.index', compact('bills', 'products'));
    }
}
