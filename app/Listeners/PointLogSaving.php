<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;

use App\Models\user;
use App\Models\pointlog;

use App\Jobs\SetPointExpirationDate;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;


class PointLogSaving
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