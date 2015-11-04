<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

use App\Libraries\JSend;

class GenerateTransactionDate extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        if(!in_array($this->transaction->status, ['wait', 'paid', 'delivered', 'shipping']))
        {
            $this->transaction->transact_at  = date('Y-m-d H:i:s', strtotime('now'));
        }

        return new JSend('success', (array)$this->transaction);
    }
}
