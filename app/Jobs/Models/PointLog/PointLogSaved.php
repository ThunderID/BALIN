<?php

namespace App\Jobs\Models\PointLog;

use App\Jobs\Job;
use App\Jobs\RecalculateUserPoints;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\User;
use App\Models\PointLog;

class PointLogSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $pointlog;

    public function __construct(PointLog $pointlog)
    {
        $this->pointlog                 = $pointlog;
    }

    public function handle()
    {
        $user                           = User::findorfail($this->pointlog->user_id);

        $result                         = $this->dispatch(new RecalculateUserPoints($user));

        return $result;
    }
}
