<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\PointLog;
use App\Models\Transaction;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class RevertUserPoints extends Job implements SelfHandling
{
    protected $pointLog;

    public function __construct(PointLog $pointLog)
    {
        $this->pointlog                 = $pointLog;
    }

    public function handle()
    {
        // checking
        if(is_null($this->pointlog->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }    

        $data                           = new pointlog;

        $user                           = User::find($this->pointlog->user_id);
        $transaction                    = transaction::find($this->pointlog->transaction_id);

        if(empty($user) && empty($transaction))
        {
            //return error
            dd('user not found');
        }

        $data->fill([
            'credit'                    => $this->pointlog->debit,  
            'debit'                     => $this->pointlog->credit, 
            'notes'                     => 'revert point',  
        ]);

        $data->user()->associate($user);
        $data->transaction()->associate($transaction);

        if(!$data->save())
        {
            dd('fail');
        }
        else
        {
            dd('success');
        }
    }
}
