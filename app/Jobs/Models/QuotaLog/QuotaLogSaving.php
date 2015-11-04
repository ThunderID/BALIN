<?php

namespace App\Jobs\Models\QuotaLog;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\QuotaLog;

class QuotaLogSaving extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $quotalog;

    public function __construct(QuotaLog $quotalog)
    {
        $this->quotalog             = $quotalog;
    }

    public function handle()
    {
        //cek 
        $result                 = new JSend('success', (array)$this->quotalog);

        return $result;
    }
}
