<?php

namespace App\Listeners;

use App\Jobs\SaveToCart;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth, Cookie;
use Illuminate\Support\Facades\Session;

class UserLoggedIn
{
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
        if(Cookie::has('baskets'))
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