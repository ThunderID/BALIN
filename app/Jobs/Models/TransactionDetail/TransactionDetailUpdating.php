<?php

namespace App\Jobs\Models\TransactionDetail;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\TransactionDetail;

class TransactionDetailUpdating extends Job implements SelfHandling
{
    protected $transactiondetail;

    public function __construct(TransactionDetail $transactiondetail)
    {
        $this->transactiondetail            = $transactiondetail;
    }

    public function handle()
    {
        return new JSend('success', (array)$this->transactiondetail );
    }
}
