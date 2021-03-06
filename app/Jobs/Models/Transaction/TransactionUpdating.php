<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Jobs\Models\Transaction\Sell\TransactionSellUpdating;
use App\Jobs\Models\Transaction\Buy\TransactionBuyUpdating;

use App\Models\Transaction;

class TransactionUpdating extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }
    
    public function handle()
    {
        switch($this->transaction->type)
        {
            case 'buy' :
                $result                     = $this->dispatch(new TransactionBuyUpdating($this->transaction));
            break;
            default :
                $result                     = $this->dispatch(new TransactionSellUpdating($this->transaction));
            break;
        }
        
        return $result;
    }
}
