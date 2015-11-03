<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Models\Transaction\Sell\TransactionSellCreated;
use App\Jobs\Models\Transaction\Buy\TransactionBuyCreated;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\transaction;

class TransactionCreated extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transaction; 

    public function __construct(Transaction $transaction)
    {
        $this->transaction               = $transaction;
    }

    public function handle()
    {
        switch($this->transaction->type)
        {
            case 'buy' :
                $result                     = $this->dispatch(new TransactionBuyCreated($this->transaction));
            break;
            default :
                $result                     = $this->dispatch(new TransactionSellCreated($this->transaction));
            break;
        }
        
        return $result;
    }
}
