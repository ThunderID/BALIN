<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Models\Transaction\Sell\TransactionSellSaving;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionSaving extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

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
                $result                     = $this->dispatch(new TransactionBuySaving($this->transaction));
            break;
            default :
                $result                     = $this->dispatch(new TransactionSellSaving($this->transaction));
            break;
        }
        
        return $result;
    }
}
