<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\PointLog;
use App\Models\Transaction;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Libraries\JSend;

class RevertUserPoints extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }    

        foreach ($this->transaction->pointlogs as $key => $value) 
        {
            $data                           = new PointLog;

            $data->fill([
                'user_id'                   => $value->user_id,  
                'transaction_id'            => $value->transaction_id,  
                'credit'                    => $value->debit,  
                'debit'                     => $value->credit, 
                'notes'                    => 'Revert '.$value->notes,  
            ]);

            if(!$data->save())
            {
                return new JSend('error', (array)$this->transaction, (array)$data->getError());
            }
        }

        return new JSend('success', (array)$this->transaction);
    }
}
