<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Job;
use App\Libraries\JSend;

use App\Jobs\Models\Transaction\Sell\TransactionSellDeleting;
use App\Jobs\Models\Transaction\Buy\TransactionBuyDeleting;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionDeleting extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction				= $transaction;
    }
    
    public function handle()
    {
        switch($this->transaction->type)
        {
            case 'buy' :
                $result                     = $this->dispatch(new TransactionBuyDeleting($this->transaction));
            break;
            default :
                $result                     = $this->dispatch(new TransactionSellDeleting($this->transaction));
            break;
        }
        
        return $result;
    }
}
