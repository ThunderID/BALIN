<?php

namespace App\Jobs\Models\TransactionLog;

use App\Jobs\Job;
use App\Jobs\CheckStock;
use App\Jobs\CheckPaid;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\TransactionLog;
use App\Models\Payment;

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
                break;
                case 'paid' :
                    $result                 = $this->dispatch(new CheckPaid($this->transactionlog->transaction, new Payment));
                break;
            }
        }

        return $result;
    }
}
