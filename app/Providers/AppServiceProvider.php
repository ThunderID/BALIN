<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionDetail::observe(new \App\Models\BaseObserver);
        \App\Models\Supplier::observe(new \App\Models\BaseObserver);
        \App\Models\Courier::observe(new \App\Models\BaseObserver);
        \App\Models\Category::observe(new \App\Models\BaseObserver);
        \App\Models\Product::observe(new \App\Models\BaseObserver);
        \App\Models\Price::observe(new \App\Models\BaseObserver);


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionDetail::observe(new \App\Models\BaseObserver);       
        \App\Models\Supplier::observe(new \App\Models\BaseObserver);       
        \App\Models\Courier::observe(new \App\Models\BaseObserver);
        \App\Models\Category::observe(new \App\Models\BaseObserver);
        \App\Models\Product::observe(new \App\Models\BaseObserver);
        \App\Models\Price::observe(new \App\Models\BaseObserver);
    }
}
