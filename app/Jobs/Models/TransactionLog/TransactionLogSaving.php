<?php

namespace App\Jobs\Models\TransactionLog;

use App\Jobs\Job;
use App\Jobs\CheckStock;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\TransactionLog;

class TransactionLogSaving extends Job implements SelfHandling
{
    protected $transactionlog;

    public function __construct(TransactionLog $transactionlog)
    {
        $this->transactionlog            = $transactionlog;
    }

    public function handle()
    {
        if($this->transactionlog->transaction->type=='sell')
        {
            switch($this->transactionlog->status)
            {
                case 'wait' :
                    $result                     = $this->dispatch(new CheckStock($this->transactionlog->transaction));
                default :
                    $result                     = new JSend('success', (array)$this->transactionlog );
                break;
            }
        }
        else
        {
            $result                             = new JSend('success', (array)$this->transactionlog );
        }

        return $result;
    }
}
