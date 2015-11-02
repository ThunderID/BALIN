<?php

namespace App\Jobs\Models\TransactionLog;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\transaction;
use App\Models\TransactionLog;

class TransactionLogCreated extends Job implements SelfHandling
{
    protected $transactionlog; 

    public function __construct(TransactionLog $transactionlog)
    {
        $this->transaction_detail               = $transactionlog;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->transactionlog );
    }
}
