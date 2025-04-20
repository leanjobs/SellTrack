<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Midtrans\Config as MidtransConfig;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $loader = AliasLoader::getInstance();
        $loader->alias('DNS1D', \Milon\Barcode\Facades\DNS1DFacade::class);
        $loader->alias('DNS2D', \Milon\Barcode\Facades\DNS2DFacade::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        MidtransConfig::$serverKey = config('midtrans.ServerKey');
        MidtransConfig::$isProduction = config('midtrans.isProduction');
        MidtransConfig::$isSanitized = config('midtrans.isSanitized');
        MidtransConfig::$is3ds = config('midtrans.is3ds');
    }
}
