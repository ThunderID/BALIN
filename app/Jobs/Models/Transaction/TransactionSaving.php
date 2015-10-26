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
        //cek 
         switch($this->transaction->type)
        {
            case 'sell' :
                $result                     = $this->dispatch(new TransactionSellSaving($this->transaction));
            break;
            default :
                $result                     = new JSend('success', (array)$this->transaction );
            break;
        }
            
        return $result;
    }
}
