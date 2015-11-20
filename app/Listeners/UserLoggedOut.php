<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth, Carbon, Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UserLoggedOut
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
        $lastlogged                 = new Carbon('now');

        $user                       = Auth::user();

        $user->last_logged_at       = $lastlogged->format('Y-m-d H:i:s');

        if(!$user->save())
        {
            return false;
        }

        Session::forget('baskets');

        return true;
    }
}