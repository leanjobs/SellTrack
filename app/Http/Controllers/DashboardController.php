<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class DashboardController extends Controller
{
    public function index()
    {
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

        return view('dashboard.index', compact('bills', 'products'));
    }

    public function print(Request $request)
    {
        $userBranchId = Auth::user()->branches_id;
        $bills = Bill::with('payment')->where('branches_id', $userBranchId)->latest()->take(10)->get();
        $products = Product::with(['incoming_stocks.outgoing_stocks'])
            ->get()->map(function ($product) use ($userBranchId) {
                $filteredIncoming = $product->incoming_stocks->filter(function ($incoming) use ($userBranchId) {
                    return $incoming->branches_id == $userBranchId;
                });
                $totalQuantity = $filteredIncoming->flatMap->outgoing_stocks->sum('quantity');
                $product->total_outgoing_quantity = $totalQuantity;
                return $product;
            })
            ->sortByDesc('total_outgoing_quantity')->take(10)->values();

        return view('print.print-dashboard', compact('request', 'bills', 'products'));
    }
}
