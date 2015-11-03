<?php

namespace App\Jobs\Models\TransactionLog;

use App\Jobs\Job;
use App\Jobs\CheckStock;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\TransactionLog;

class TransactionLogSaving extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $transactionlog;

    public function __construct(TransactionLog $transactionlog)
    {
        $this->transactionlog               = $transactionlog;
    }

    public function handle()
    {
        $result                             = new JSend('success', (array)$this->transactionlog );

        if($this->transactionlog->transaction->type=='sell')
        {
            switch($this->transactionlog->status)
            {
                case 'wait' :
                    $result                 = $this->dispatch(new CheckStock($this->transactionlog->transaction));
                    
                    if($result->getStatus()=='success')
                    {
                        if($this->transactionlog->transaction->amount==0)
                        {
                            $this->transactionlog->status   = 'paid';
                        }
                    }
                break;
            }
        }

        return $result;
    }
}
