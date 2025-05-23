<?php

use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\DiscountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/discounts', DiscountController::class);

Route::post('/handle-midtrans', [MidtransController::class, 'handleMidtrans']);
