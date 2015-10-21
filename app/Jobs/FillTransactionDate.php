<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\transaction;

use App\Libraries\JSend;

class FillTransactionDate extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        if($this->transaction->status == 'draft' || $this->transaction->status == 'waiting')
        {
            $this->transaction->transacted_at  = date('Y-m-d H:i:s', strtotime('now'));
        }

        return new jsend('success', (array)$this->transaction);
    }
}
