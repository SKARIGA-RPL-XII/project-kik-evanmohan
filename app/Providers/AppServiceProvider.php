<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Kirim jumlah item keranjang ke semua view
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cartItems = Keranjang::where('user_id', Auth::id())
                    ->with('product')
                    ->get();

                $cartTotal = $cartItems->sum(function ($item) {
                    return $item->qty * $item->harga_satuan;
                });

                $cartCount = $cartItems->sum('qty');
            } else {
                $cartItems = collect();
                $cartTotal = 0;
                $cartCount = 0;
            }

            $view->with([
                'cartItems' => $cartItems,
                'cartTotal' => $cartTotal,
                'cartCount' => $cartCount
            ]);
        });
    }
}
