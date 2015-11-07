<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = 
    [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //

        $gate->define('manager', function ($user)
        {
            if(in_array($user->role, ['store_manager', 'admin']))
            {
                return true;
            }

            return false;
        });

        $gate->define('admin', function ($user)
        {
            if(in_array($user->role, ['admin']))
            {
                return true;
            }

            return false;
        });
    }
}
