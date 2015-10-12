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

class TrackOrderPayment extends Job implements SelfHandling
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
        $this->payment          = $payment;
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
        $result                     = false;

        switch ($this->payment->transaction->status) 
        {
            case 'draft': case 'canceled': case 'paid': case 'shipped': case 'delivered':
                break;
            case 'waiting':
                $result             = $this->dispatch(new TrackWaitingPayment($this->payment->transaction));
                break;
            default:
                throw new Exception('Transaction status invalid.');
                break;
        }

        if(!isset($results))
        {
            $errors                 = $errors->add('Stock', 'Payment Invalid');
            $results                = new Jsend('error', (array)$this->payment, (array)$errors);
        }

        return $results;
    }
}
