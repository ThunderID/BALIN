<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use App\Models\pointlogs;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

class PointIsAvailable extends Job implements SelfHandling
{
    //cek sebelum poin mau dipotong cukup kah balance nya?
    protected $user, $ammount;

    public function __construct(user $user, $ammount)
    {
        $this->user                     = $user;
        $this->ammount                  = (double)$ammount;
    }

    public function handle()
    {
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $point                          = $this->user->balance;
    
        if($this->ammount <= $point)
        {
            $result                     = new Jsend('success', ['message' => 'Point available']);
        }
        else
        {
            $result                     = new Jsend('fail', ['message' => 'insufficient points']);
        }

        return $result;
    }
}
