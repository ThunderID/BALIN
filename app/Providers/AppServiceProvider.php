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
            return "<?php echo with{$expression}->format('d-m-Y H:i'); ?>";
        });

        \App\Models\Transaction::observe(new \App\Models\BaseObserver);
        \App\Models\TransactionDetail::observe(new \App\Models\BaseObserver);
        \App\Models\Supplier::observe(new \App\Models\BaseObserver);
        \App\Models\Courier::observe(new \App\Models\BaseObserver);
        \App\Models\Category::observe(new \App\Models\BaseObserver);
        \App\Models\Product::observe(new \App\Models\BaseObserver);
        \App\Models\Price::observe(new \App\Models\BaseObserver);
        \App\Models\User::observe(new \App\Models\BaseObserver);


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
    }
}
