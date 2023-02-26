<?php

namespace App\Providers;

use App\Models\brands;
use App\Models\clients;
use App\Models\orders;
use App\Models\products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewShareProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            $view->with([
                'appbrdata'  => brands::orderBy('id', 'desc')->where(
                    'user_id',
                    '=',
                    Auth::id()
                )->get(),
                'appcldata'  => clients::orderBy('id', 'desc')->where(
                    'user_id',
                    '=',
                    Auth::id()
                )->get(),
                'appprdata'  => products::join(
                    'brands',
                    'brands.id',
                    '=',
                    'products.brands_id'
                )
                    ->select(
                        'brands.name AS brname',
                        'products.id',
                        'products.name',
                        'products.quantity',
                        'products.buy',
                        'products.sale'
                    )
                    ->where('products.user_id', '=', Auth::id())
                    ->get(),
                'appbuysum'  => products::where('user_id', '=', Auth::id())
                    ->sum(
                        'buy'
                    ),
                'appsalesum' => products::where(
                    'products.user_id',
                    '=',
                    Auth::id()
                )->sum('sale'),
                'appqsum'    => orders::where('orders.user_id', '=', Auth::id())
                    ->sum('quantity'),
                'appprof'    => products::join(
                    'orders',
                    'orders.products_id',
                    '=',
                    'products.id'
                )
                    ->where('orders.user_id', '=', Auth::id())
                    ->selectraw(
                        'sum((products.sale - products.buy) * orders.quantity) AS profit'
                    )
                    ->get(),
                'appcprof'   => products::join(
                    'orders',
                    'orders.products_id',
                    '=',
                    'products.id'
                )
                    ->selectraw(
                        'sum((products.sale - products.buy) * orders.quantity) AS cprofit'
                    )
                    ->where('orders.user_id', '=', Auth::id())->where(
                        'orders.confirm',
                        '=',
                        '1'
                    )
                    ->get()
            ]);
        });
    }
}
