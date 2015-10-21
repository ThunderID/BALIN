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
use Illuminate\Support\MessageBag as MessageBag;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;

class TrackWaitingOrder extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct(Transaction $transaction)
    {
        $this->transaction          = $transaction;
    }

    public function handle()
    {
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $errors                     = new MessageBag;

        $flag                       = false;

        $is_paid                    = $this->dispatch(new PaymentIsValid($this->transaction));

        if($is_paid->getStatus()=='error')
        {
            $flag                   = true;
        }

        $is_shipped                 = $this->dispatch(new ShippingNoted($this->transaction));

        if($is_shipped->getStatus()=='error')
        {
            $flag                   = true;
        }

        if($flag)
        {
            $is_calculated          = $this->dispatch(new StockRecalculate($this->transaction));
        
            if($is_calculated->getStatus()=='success')
            {
                $results            = $this->dispatch(new SendBillingEmail($this->transaction));
            }
            else
            {
                $is_calculated      = $results;
            }

        }
        else
        {
            $errors                 = $errors->add('Validate', 'Draft invalid');
            $results                = new Jsend('error', (array)$this->transaction, (array)$errors);
        }

        return $results;
    }
}
