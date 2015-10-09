<?php

namespace App\Jobs;

/*
    Input   : Instance of transaction with transaction ID (exists transaction)
    Process : Count Reserved stock, current stock and on hold stock in based on transactions' products quantity + saved stock
    Output  : JSEND format, if errors will displayed errors with error message, if success return transaction model
*/

use App\Jobs\Job;
use App\Models\Transaction;

use Illuminate\Contracts\Bus\SelfHandling;
use \Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

class SwitchTransaction extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        //
        $this->transaction          = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $errors                     = new MessageBag;

        switch ($transaction->type) 
        {
            case 'buy':
                    $result         = $this->dispatch(new TrackPurchaseTransaction($transaction));
                break;
            case 'sell':
                    $result         = $this->dispatch(new TrackOrderTransaction($transaction));
                break;
            default:
                throw new Exception('Transaction type must be one of buy or sell.');
                break;
        }

        if(!isset($result))
        {
            $errors->add('transaction', 'Transaction not listed.'); 
        }

        if($errors->count())
        {
            $result                 = new Jsend('error', (array)$this->transaction, (array)$errors);
        }

        return $result;
    }
}
