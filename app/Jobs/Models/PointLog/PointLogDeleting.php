<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\pointlog;

class PointLogDeleting extends Job implements SelfHandling
{
    protected $pointLog;

    public function __construct(pointlog $pointlog)
    {
        $this->pointLog                 = $pointLog;
    }

    public function handle()
    {
        return new Jsend('success', (array)$this->pointLog);
    }
}
