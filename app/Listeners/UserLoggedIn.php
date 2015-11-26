<?php

namespace App\Listeners;

use App\Jobs\SaveToCart;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth, Session;
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
        if(Session::has('baskets') && !is_null(Session::get('baskets')) && !empty(Session::get('baskets')))
        {
            $result                 = $this->dispatch(new SaveToCart(Session::get('baskets')));

            if($result->getStatus()=='success')
            {
                Session::forget('baskets');

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