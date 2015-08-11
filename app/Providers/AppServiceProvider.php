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
        \Models\Category::observe(new \Models\Observers\categoryObserver);
        \Models\courier::observe(new \Models\Observers\courierObserver);
        \Models\Category::observe(new \Models\Observers\categoryObserver);
        \Models\Credit_log::observe(new \Models\Observers\credit_logObserver);
        \Models\Customer::observe(new \Models\Observers\customerObserver);
        \Models\Image::observe(new \Models\Observers\imageObserver);
        \Models\Inventory::observe(new \Models\Observers\InventoryObserver);
        \Models\Payment::observe(new \Models\Observers\paymentObserver);
        \Models\Price::observe(new \Models\Observers\priceObserver);
        \Models\Product_category::observe(new \Models\Observers\productCategoryObserver);
        \Models\Product::observe(new \Models\Observers\productObserver);
        \Models\Setting::observe(new \Models\Observers\settingObserver); 
        \Models\Shipping::observe(new \Models\Observers\shippingObserver);
        \Models\Transaction_detail::observe(new \Models\Observers\transactionDetailObserver);
        \Models\Transaction::observe(new \Models\Observers\transactionObserver);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Models\Category::observe(new \Models\Observers\categoryObserver);
        \Models\courier::observe(new \Models\Observers\courierObserver);
        \Models\Category::observe(new \Models\Observers\categoryObserver);
        \Models\Credit_log::observe(new \Models\Observers\credit_logObserver);
        \Models\Customer::observe(new \Models\Observers\customerObserver);
        \Models\Image::observe(new \Models\Observers\imageObserver);
        \Models\Inventory::observe(new \Models\Observers\inventoryObserver);
        \Models\Payment::observe(new \Models\Observers\paymentObserver);
        \Models\Price::observe(new \Models\Observers\priceObserver);
        \Models\Product_category::observe(new \Models\Observers\productCategoryObserver);
        \Models\Product::observe(new \Models\Observers\productObserver);
        \Models\Setting::observe(new \Models\Observers\settingObserver); 
        \Models\Shipping::observe(new \Models\Observers\shippingObserver);
        \Models\Transaction_detail::observe(new \Models\Observers\transactionDetailObserver);
        \Models\Transaction::observe(new \Models\Observers\transactionObserver);
    }
}
