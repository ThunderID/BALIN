<?php

namespace App\Jobs\Models\PointLog;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\PointLog;

class PointLogDeleted extends Job implements SelfHandling
{
    protected $pointlog;

    public function __construct(PointLog $pointlog)
    {
        $this->pointlog                 = $pointlog;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->pointlog);
    }
}