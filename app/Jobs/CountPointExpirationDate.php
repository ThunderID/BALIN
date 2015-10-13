<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use App\Models\policy;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

class CountPointExpirationDate extends Job implements SelfHandling
{
    protected $user;

    public function __construct(user $user)
    {
        $this->user                 = $user;
    }


    public function handle()
    {
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        try 
        {
            $join_date                  = $this->user['joined_at'];

            $expired_range              = Policy::type('reset_point')->ondate('now')->first();

            $expired_date               = date('Y-m-d H:i:s', strtotime($join_date . $expired_range['value']));

            do {
                $expired_date           = date('Y-m-d H:i:s', strtotime($expired_date   . $expired_range['value']));
            } while ($expired_date < date('Y-m-d H:i:s'));

            $result                     = new Jsend('success', ['expired_date' => $expired_date]);

        } 
        catch (Exception $e) 
        {
            $result                     = new Jsend('fail', (array)$e);
        }

        return $result;
    }
}
