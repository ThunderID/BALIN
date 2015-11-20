<?php

namespace App\Jobs\Models\QuotaLog;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\QuotaLog;
use App\Jobs\Auditors\SaveAuditQuota;

class QuotaLogSaved extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $quotalog;

    public function __construct(QuotaLog $quotalog)
    {
        $this->quotalog             = $quotalog;
    }

    public function handle()
    {
    	$result                     = $this->dispatch(new SaveAuditQuota($this->quotalog));

        return $result;
    }
}
