<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Job;
use App\Jobs\SendBillingEmail;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;


class TransactionSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        switch($this->transaction->status)
        {
            case 'waiting' :
                $result                     = $this->dispatch(new SendBillingEmail($this->transaction));
            break;
            default :
                $result                     = new JSend('success', (array)$this->transaction );
            break;
        }

        return $result;
    }
}
