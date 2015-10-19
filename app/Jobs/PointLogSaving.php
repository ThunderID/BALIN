<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests

use App\Models\user;
use App\Models\pointlog;

class PointLogSaving extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //
    }

    public function handle(pointlog $pointlog)
    {
        $result                         = $this->dispatch(new SetPointExpirationDate($pointlog));

        if($result->getStatus() != 'success')
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}
