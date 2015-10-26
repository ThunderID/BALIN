<?php

namespace App\Jobs\Models\TransactionDetail;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\transaction;
use App\Models\TransactionDetail;

class TransactionDetailCreated extends Job implements SelfHandling
{
    protected $transactiondetail; 

    public function __construct(TransactionDetail $transactiondetail)
    {
        $this->transaction_detail               = $transactiondetail;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->transactiondetail );
    }
}
