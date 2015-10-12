<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use App\Models\user;
use App\Models\transaction;
use Illuminate\Contracts\Bus\SelfHandling;

class CheckIsCustomerHasProcessedTransaction extends Job implements SelfHandling
{
    protected $user;

    public function __construct(user $user)
    {
        $this->user             = $user;
    }

    public function handle()
    {
        // checking
        if(is_null($this->user->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //check is user has processed transaction
        $transaction            = transaction::where('user_id',$this->user->id)
                                    ->TransactionProcessed()
                                    ->first();

        if($transaction)
        {
            $result             = new Jsend('success', (array)$transaction);;
        }
        else
        {
            $result             = new Jsend('error', (array)$this->user, 'No transaction has been paid');
        }

        return $result;
    }
}
