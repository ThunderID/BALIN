<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\User;
use APP\Models\PointLog;
use App\Libraries\JSend;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SetPointExpirationDate extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    Protected $pointlog;

    public function __construct(PointLog $pointlog)
    {
        $this->pointlog                     =   $pointlog;
    }


    public function handle()
    {
        try
        {
            $user                          = user::find($this->pointlog['user_id']);

            $expired_date                  = $this->dispatch(new CountPointExpirationDate($user));
            if($expired_date->getStatus() != 'success')
            {
                return $expired_date;
            }

            $this->pointlog->expired_date  = $expired_date->getData()['expired_date'];

            $result                        = new Jsend('success', 'Expired date added');
        } 
        catch (Exception $e) 
        {
            $result                        = new Jsend('fail', (array)$e);
        }        

        return $result ;
    }
}
