<?php

namespace App\Jobs\Models\TransactionLog;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\TransactionLog;

class TransactionLogCreating extends Job implements SelfHandling
{
    protected $transactionlog;

    public function __construct(TransactionLog $transactionlog)
    {
        $this->transactionlog            = $transactionlog;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->transactionlog );
    }
}
