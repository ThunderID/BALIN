<?php

namespace App\Jobs\Models\Transaction\Buy;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionBuyDeleting extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        //need to check user active or not
        $result                             = new JSend('success', (array)$this->transaction);

        foreach ($this->transaction->transactiondetails as $key => $value) 
        {
            if(!$value->delete())
            {
                $result                     = new JSend('error', (array)$this->transaction, $value->getError());

                return $result;
            }
        }

        foreach ($this->transaction->transactionlogs as $key => $value) 
        {
            if(!$value->delete())
            {
                $result                     = new JSend('error', (array)$this->transaction, $value->getError());

                return $result;
            }
        }

        return $result;
    }
}
