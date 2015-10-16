<?php

namespace App\Jobs;

use App\Models\PointLog;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class RevertUserPoints extends Job implements SelfHandling
{
    protected $pointLog;

    public function __construct(PointLog $pointLog)
    {
        $this->pointlog                 = $pointLog;
    }

    public function handle()
    {
        // checking
        if(is_null($this->pointlog->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }    

        $debit                          = $this->pointlog->debit;
        $credit                         = $this->pointlog->credit;


    }
}
