<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade, Config;

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

        Blade::directive('date_with_name_month_indo', function($expression) 
        {
            return "<?php echo with{$expression}->format('d-M-Y'); ?>";
        });

        Blade::directive('datetime_indo', function($expression) 
        {
            return "<?php echo with{$expression}->format('d-m-Y H:i'); ?>";
        });

        Blade::directive('datetime_with_name_month_indo', function($expression) 
        {
            return "<?php echo with{$expression}->format('d F Y  |  H:i'); ?>";
        });

        Blade::directive('money_indo', function($expression)
        {
            return "<?php echo 'IDR '.number_format($expression, 0, ',', '.'); ?>";
        });
 
        Config::set('fb_app.id', '491225264379551');

        \App\Models\User::observe(new \App\Models\BaseObserver);
        \App\Models\Supplier::observe(new \App\Models\BaseObserver);
        \App\Models\Courier::observe(new \App\Models\BaseObserver);
        \App\Models\ShippingCost::observe(new \App\Models\BaseObserver);
        \App\Models\Address::observe(new \App\Models\BaseObserver);
        
        \App\Models\Product::observe(new \App\Models\BaseObserver);
        \App\Models\GlobalCategory::observe(new \App\Models\BaseObserver);
        \App\Models\Category::observe(new \App\Models\BaseObserver);
        \App\Models\Tag::observe(new \App\Models\BaseObserver);
        \App\Models\Price::observe(new \App\Models\BaseObserver);
        \App\Models\Varian::observe(new \App\Models\BaseObserver);
        \App\Models\Lable::observe(new \App\Models\BaseObserver);
        \App\Models\Image::observe(new \App\Models\BaseObserver);
        
        \App\Models\Voucher::observe(new \App\Models\BaseObserver);
        \App\Models\PointLog::observe(new \App\Models\BaseObserver);
        \App\Models\QuotaLog::observe(new \App\Models\BaseObserver);

        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionDetail::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionLog::observe(new \App\Models\BaseObserver);

        \App\Models\Payment::observe(new \App\Models\BaseObserver);
        \App\Models\Shipment::observe(new \App\Models\BaseObserver);

        \App\Models\StoreSetting::observe(new \App\Models\BaseObserver);
        \App\Models\Auditor::observe(new \App\Models\BaseObserver);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \App\Models\User::observe(new \App\Models\BaseObserver);
        \App\Models\Supplier::observe(new \App\Models\BaseObserver);
        \App\Models\Courier::observe(new \App\Models\BaseObserver);
        \App\Models\ShippingCost::observe(new \App\Models\BaseObserver);
        \App\Models\Address::observe(new \App\Models\BaseObserver);
        
        \App\Models\Product::observe(new \App\Models\BaseObserver);
        \App\Models\GlobalCategory::observe(new \App\Models\BaseObserver);
        \App\Models\Category::observe(new \App\Models\BaseObserver);
        \App\Models\Tag::observe(new \App\Models\BaseObserver);
        \App\Models\Price::observe(new \App\Models\BaseObserver);
        \App\Models\Varian::observe(new \App\Models\BaseObserver);
        \App\Models\Lable::observe(new \App\Models\BaseObserver);
        \App\Models\Image::observe(new \App\Models\BaseObserver);
        
        \App\Models\Voucher::observe(new \App\Models\BaseObserver);
        \App\Models\PointLog::observe(new \App\Models\BaseObserver);
        \App\Models\QuotaLog::observe(new \App\Models\BaseObserver);

        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionDetail::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionLog::observe(new \App\Models\BaseObserver);

        \App\Models\Payment::observe(new \App\Models\BaseObserver);
        \App\Models\Shipment::observe(new \App\Models\BaseObserver);

        \App\Models\StoreSetting::observe(new \App\Models\BaseObserver);
        \App\Models\Auditor::observe(new \App\Models\BaseObserver);
    }
}
