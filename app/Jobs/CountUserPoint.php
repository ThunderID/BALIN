<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use App\Models\pointlogs;
use Illuminate\Contracts\Bus\SelfHandling;

class CountUserPoint extends Job implements SelfHandling
{
    protected $user;

    public function __construct(user $user)
    {
        $this->user                     = $user;
    }

    public function handle()
    {
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $point                          = $this->user->balance
                                            // ->where('pointlogs.expired_date','>=',date('Y-m-d H:i:s') )
                                            ;
    
        dd($this->point );

    }
}
