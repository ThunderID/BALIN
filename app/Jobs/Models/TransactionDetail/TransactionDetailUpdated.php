<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\transactiondetail;

class TransactionDetailUpdated extends Job implements SelfHandling
{
    protected $transactiondetail;

    public function __construct(transactiondetail $transactiondetail)
    {
        $this->transactiondetail            = $transactiondetail;
    }

    public function handle()
    {
        return new Jsend('success', (array)$this->transactiondetail );
    }
}
