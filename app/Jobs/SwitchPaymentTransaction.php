<?php

namespace App\Jobs;

/*
    Input   : Instance of transaction with transaction ID (exists transaction)
    Process : Count Reserved stock, current stock and on hold stock in based on transactions' products quantity + saved stock
    Output  : JSEND format, if errors will displayed errors with error message, if success return transaction model
*/

use App\Jobs\Job;
use App\Models\Payment;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;

class SwitchPaymentTransaction extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        //
        $this->payment              = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if(is_null($this->payment->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $errors                     = new MessageBag;

        switch ($this->payment->transaction->type) 
        {
            case 'buy':
                break;
            case 'sell':
                    if($this->payment->transaction_id)
                    {
                        $result     = $this->dispatch(new validatePayment($this->payment));

                        if($result->getStatus() == 'success')
                        {
                            $result = $this->dispatch(new TrackOrderPayment($this->payment));
                        }
                    }
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
            $result                 = new Jsend('error', (array)$this->payment, (array)$errors);
        }

        return $result;
    }
}
