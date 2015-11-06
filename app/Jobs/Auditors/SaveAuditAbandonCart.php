<?php

namespace App\Jobs\Auditors;

// change status
use App\Jobs\Job;

use App\Models\Transaction;
use App\Models\Auditor;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use Carbon;

class SaveAuditAbandonCart extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $result                             = new JSend('success', (array)$this->transaction);

        $previoustrans                      = Transaction::userid($this->transaction->user_id)->notid($this->transaction->id)->status('cart')->first();

        if($previoustrans)
        {
            $audit                          = new Auditor;

            $audit->fill([
                    'user_id'               => $previoustrans->user_id,
                    'type'                  => 'abandoned_cart',
                    'ondate'                => Carbon::now()->format('Y-m-d H:i:s'),
                    'event'                 => 'Abandoned Cart',
                ]);

            $audit->table()->associate($previoustrans);

            if(!$audit->save())
            {
                $result                     = new JSend('error', (array)$this->transaction, $audit->getError());
            }
        }

        return $result;
    }
}
