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
        // \Models\category::observe(new \Models\Observers\categoryObserver);
        // \Models\category_product::observe(new \Models\Observers\category_productObserver);
        // \Models\product::observe(new \Models\Observers\productObserver);
        // \Models\attribute::observe(new \Models\Observers\attributeObserver);
        // \Models\price::observe(new \Models\Observers\priceObserver);

        // \Models\supplier::observe(new \Models\Observers\supplierObserver);

        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionDetail::observe(new \App\Models\BaseObserver);
        \App\Models\Supplier::observe(new \App\Models\BaseObserver);
        \App\Models\Category::observe(new \App\Models\BaseObserver);
        \App\Models\Product::observe(new \App\Models\BaseObserver);


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // \Models\category::observe(new \Models\Observers\categoryObserver);
        // \Models\category_product::observe(new \Models\Observers\category_productObserver);
        // \Models\product::observe(new \Models\Observers\productObserver);
        // \Models\attribute::observe(new \Models\Observers\attributeObserver);
        // \Models\price::observe(new \Models\Observers\priceObserver);

        // \Models\supplier::observe(new \Models\Observers\supplierObserver);
        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionDetail::observe(new \App\Models\BaseObserver);       
        \App\Models\Supplier::observe(new \App\Models\BaseObserver);       
        \App\Models\Category::observe(new \App\Models\BaseObserver);
        \App\Models\Product::observe(new \App\Models\BaseObserver);
    }
}
