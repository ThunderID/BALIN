<?php

namespace App\Jobs\Models\QuotaLog;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\QuotaLog;

class QuotaLogRestoring extends Job implements SelfHandling
{
    protected $quotalog;

    public function __construct(QuotaLog $quotalog)
    {
        $this->quotalog             = $quotalog;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->quotalog);
    }
}
