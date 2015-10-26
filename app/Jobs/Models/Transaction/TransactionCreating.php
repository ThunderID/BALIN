<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Models\Transaction\Buy\TransactionBuyCreating;

use App\Jobs\Job;
use App\Jobs\GenerateTransactionRefNumber;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class TransactionCreating extends Job implements SelfHandling
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
                $result                     = $this->dispatch(new TransactionBuyCreating($this->transaction));
            break;
            default :
                $result                          = new JSend('success', (array)$this->transaction );
            break;
        }

        return $result;
    }
}
