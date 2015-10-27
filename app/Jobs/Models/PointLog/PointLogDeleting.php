<?php

namespace App\Jobs\Models\PointLog;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\PointLog;

class PointLogDeleting extends Job implements SelfHandling
{
    protected $pointLog;

    public function __construct(PointLog $pointlog)
    {
        $this->pointlog                 = $pointlog;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->pointlog);
    }
}
