<?php

namespace App\Jobs;

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

    public function __construct(transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        //cek 
        $result                     = $this->dispatch(new checkReferralCode($this->transaction));

        if($result->getStatus() == 'success')
        {
            $result                 = $this->dispatch(new FillTransactionDate($this->transaction));

            if($result->getStatus() == 'success')
            {
                $result             = $this->dispatch(new GenerateTransactionRefNumber($this->transaction));
            }
        }
            
        return $result;
    }
}
