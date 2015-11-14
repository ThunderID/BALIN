<?php

namespace App\Listeners;

use App\Jobs\SaveToCart;
use App\Jobs\SaveToCookie;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth, Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Models\Transaction;

class UserLoggedIn
{
    use DispatchesJobs;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserAuthenticated  $event
     * @return void
     */
    public function handle()
    {
        if(Cookie::has('baskets') && !is_null(Cookie::Get('baskets')) && !empty(Cookie::Get('baskets')))
        {
            $result                 = $this->dispatch(new SaveToCart(Cookie::Get('baskets')));

            if($result->getStatus()=='success')
            {
                Cookie::forget('baskets');

                return true;
            }
            else
            {
                return false;
            }
        }
        
        return true;
    }
}