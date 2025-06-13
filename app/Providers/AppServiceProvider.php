<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $user = Auth::user();
                $cart = Cart::where('user_id', $user->id)->where('status', 'pendiente')->first();

                if ($cart) {
                    $cartCount = $cart->items()->sum('cantidad');
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
