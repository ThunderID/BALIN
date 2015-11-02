<?php

namespace App\Jobs;

// check all quantity
use App\Jobs\Job;

use App\Models\Transaction;
use App\Models\PointLog;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

class DebitReferralPoint extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction              = $transaction;
    }

    public function handle()
    {
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        foreach ($transaction->pointlogs as $key => $value) 
        {
            $point                      = new PointLog;
            $point->fill([
                    'user_id'           => $points[$idx]->user_id,
                    'point_log_id'      => $points[$idx]->id,
                    'amount'            => $points[$idx]->amount,
                    'expired_at'        => $points[$idx]->expired_at,
                    'notes'             => 'Revert Belanja ',
                ]);

            if(!$point->save())
            {
                return new JSend('error', (array)$this->transaction, $point->getError());
            }
        }
        
        $result                         = new JSend('success', (array)$this->transaction);
        
        return $result;
    }
}
