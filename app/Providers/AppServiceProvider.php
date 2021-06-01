<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        Relation::morphMap([
            'orders' => 'App\Models\Order',
        ]);

        // observers
        \App\Models\Cart::observe(\App\Observers\CartObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
    }
}
