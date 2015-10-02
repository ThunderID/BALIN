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
        \Models\category::observe(new \Models\Observers\categoryObserver);
        \Models\category_product::observe(new \Models\Observers\category_productObserver);
        \Models\product::observe(new \Models\Observers\productObserver);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Models\category::observe(new \Models\Observers\categoryObserver);
        \Models\category_product::observe(new \Models\Observers\category_productObserver);
        \Models\product::observe(new \Models\Observers\productObserver);

    }
}
