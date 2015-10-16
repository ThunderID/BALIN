<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;

use App\Models\user;
use App\Models\pointlog;

use App\Jobs\recalculateUserPoints;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;


class PointLogSaved
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