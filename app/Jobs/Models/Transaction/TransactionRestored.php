<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\Transaction;

class TransactionRestored extends Job implements SelfHandling
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
                $result                     = $this->dispatch(new TransactionBuyRestored($this->transaction));
            break;
            default :
                $result                     = $this->dispatch(new TransactionSellRestored($this->transaction));
            break;
        }
        
        return $result;
    }
}
