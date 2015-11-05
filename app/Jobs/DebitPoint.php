<?php

namespace App\Jobs;

//to count how much point cuts for trs
use App\Jobs\Job;

use App\Models\Transaction;
use App\Models\PointLog;
use App\Models\StoreSetting;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use Exception;

class DebitPoint extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction, $debit)
    {
        $this->transaction                  = $transaction;
        $this->debit                        = $debit;
    }

    public function handle()
    {
        if(!is_null($this->transaction->id))
        {
            $expired                    = StoreSetting::type('voucher_point_expired')->Ondate('now')->first();

            if($expired)
            {
                $point                  = new PointLog;
                $point->fill([
                        'user_id'       => $this->transaction->user_id,
                        'amount'        => $this->debit,
                        'expired_at'    => date('Y-m-d H:i:s', strtotime($this->transaction->transact_at.' '.$expired->value)),
                        'notes'         => 'Bonus Belanja dengan Voucher ',
                    ]);

                $point->reference()->associate($this->transaction);

                if(!$point->save())
                {
                    return new JSend('error', (array)$this->transaction, $point->getError());
                }
            }
        }

        $result                         = new JSend('success', (array)$this->transaction);
        
        return $result;
    }
}
