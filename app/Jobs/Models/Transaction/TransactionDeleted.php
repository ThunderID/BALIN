<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Jobs\Models\Transaction\Sell\TransactionSellDeleted;
use App\Jobs\Models\Transaction\Buy\TransactionBuyDeleted;

use App\Models\Transaction;


class TransactionDeleted extends Job implements SelfHandling
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
                $result                     = $this->dispatch(new TransactionBuyDeleted($this->transaction));
            break;
            default :
                $result                     = $this->dispatch(new TransactionSellDeleted($this->transaction));
            break;
        }
        
        return $result;
    }
}
