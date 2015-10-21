<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\transaction;
use App\Models\transactiondetail;

class TransactionDetailCreated extends Job implements SelfHandling
{
    protected $transaction_detail; 

    public function __construct(transactiondetail $transactiondetail)
    {
        $this->transaction_detail               = $transactiondetail;
    }

    public function handle()
    {
        $result                                 = new jsend('success', (array)'Sukses' );

        return $result;
    }

}
