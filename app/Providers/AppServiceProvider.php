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
        \Models\Customer::observe(new \Models\Observers\customerObserver);
        \Models\Credit_log::observe(new \Models\Observers\credit_logObserver);
        \Models\Shipping::observe(new \Models\Observers\shippingObserver);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Models\Customer::observe(new \Models\Observers\customerObserver);
        \Models\Credit_log::observe(new \Models\Observers\credit_logObserver);
        \Models\Shipping::observe(new \Models\Observers\shippingObserver);
    }
}
