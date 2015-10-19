<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\user;
use App\Models\pointlog;

class PointLogSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //
    }

    public function handle(pointlog $pointlog)
    {
        $user                           = User::find($pointlog['user_id']);
        $result                         = $this->dispatch(new recalculateUserPoints($user));

        return $result;
    }
}
