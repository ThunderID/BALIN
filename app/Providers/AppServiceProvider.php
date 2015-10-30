<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('date_indo', function($expression) 
        {
            return "<?php echo with{$expression}->format('d-m-Y'); ?>";
        });

        Blade::directive('datetime_indo', function($expression) 
        {
            return "<?php echo with{$expression}->format('d-m-Y H:i'); ?>";
        });

        Blade::directive('money_indo', function($expression)
        {
            return "<?php echo 'Rp '.number_format($expression, 2, ',', '.'); ?>";
        });

        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionDetail::observe(new \App\Models\BaseObserver);
        \App\Models\Supplier::observe(new \App\Models\BaseObserver);
        \App\Models\Courier::observe(new \App\Models\BaseObserver);
        \App\Models\Category::observe(new \App\Models\BaseObserver);
        \App\Models\Product::observe(new \App\Models\BaseObserver);
        \App\Models\Price::observe(new \App\Models\BaseObserver);
        \App\Models\User::observe(new \App\Models\BaseObserver);
        \App\Models\Payment::observe(new \App\Models\BaseObserver);
        \App\Models\Shipment::observe(new \App\Models\BaseObserver);
        \App\Models\PointLog::observe(new \App\Models\BaseObserver);
        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\ShippingCost::observe(new \App\Models\BaseObserver);
        \App\Models\FeaturedProduct::observe(new \App\Models\BaseObserver);
        \App\Models\StoreSetting::observe(new \App\Models\BaseObserver);
        \App\Models\Image::observe(new \App\Models\BaseObserver);
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
        \App\Models\User::observe(new \App\Models\BaseObserver);
        \App\Models\Payment::observe(new \App\Models\BaseObserver);
        \App\Models\Shipment::observe(new \App\Models\BaseObserver);
        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\PointLog::observe(new \App\Models\BaseObserver);
        \App\Models\ShippingCost::observe(new \App\Models\BaseObserver);
        \App\Models\FeaturedProduct::observe(new \App\Models\BaseObserver);
        \App\Models\StoreSetting::observe(new \App\Models\BaseObserver);
        \App\Models\Image::observe(new \App\Models\BaseObserver);
    }
}
