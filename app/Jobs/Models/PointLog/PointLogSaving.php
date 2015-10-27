<?php

namespace App\Jobs\Models\PointLog;

use App\Jobs\Job;
use App\Jobs\SetPointExpirationDate;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\PointLog;
use App\Libraries\JSend;

class PointLogSaving extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $pointlog;

    public function __construct(PointLog $pointlog)
    {
        $this->pointlog                 = $pointlog;
    }

    public function handle()
    {
        $result                        = new JSend('success', (array)$this->pointlog);

        return $result;
    }
}
