<?php

use App\Http\Controllers\ApiLocation;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\IncomingStockController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OutgoingStockController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

Route::get("/", function(){
    return view('welcome');
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'RoleCheck:super_admin,admin,staff']], function(){
    Route::resource('/members', MemberController::class);
    Route::resource('/incoming-stocks', IncomingStockController::class);
    Route::resource('/outgoing-stocks', OutgoingStockController::class);
    Route::resource('/bills', BillController::class);


    Route::get('/pos-system',[ PosController::class, 'index'] );
    Route::get('/dashboard',[ DashboardController::class, 'index'] );


    Route::get('/filter-products',[ PosController::class, 'filterProducts'])->name('filter.products');


});

Route::group(['middleware' => ['auth', 'RoleCheck:super_admin,admin']], function(){
    Route::resource('/discounts', DiscountController::class);
    Route::get('/dashboard-print',[ DashboardController::class, 'print'])->name('print.dashboard');
    Route::get('/bills-print',[ BillController::class, 'print'])->name('print.bills');
    Route::get('/products-print',[ ProductController::class, 'print'])->name('print.products');

});

Route::group(['middleware' => ['auth', 'RoleCheck:super_admin']], function(){
    Route::resource('/products', ProductController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/branches', BranchController::class);
    Route::resource('/users', UserController::class);

    Route::get('/get-provinces',[ ApiLocation::class, 'getProvinces']);
    Route::get('/get-cities/{province_id}',[ ApiLocation::class, 'getCity']);
    Route::get('/get-sub-districts/{city_id}',[ ApiLocation::class, 'getSubDistrict']);
    Route::get('/get-postal-code/{city_id}/{sub_district}',[ ApiLocation::class, 'getPostalCode']);

});

