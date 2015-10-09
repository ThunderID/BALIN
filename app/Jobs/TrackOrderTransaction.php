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

class TrackOrderTransaction extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

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
        $result                     = false;

        switch ($this->transaction->status) 
        {
            case 'draft':
                    $result         = $this->draft();
                break;
            case 'waiting':
                    $result         = $this->waiting();
                break;
            case 'paid':
                    $result         = $this->paid();
                break;
            case 'shipped':
                    $result         = $this->shipped();
                break;
            case 'delivered':
                    $result         = $this->delivered();
                break;
            case 'canceled':
                    $result         = $this->canceled();
                break;
            default:
                throw new Exception('Transaction status invalid.');
                break;
        }

        if($result)
        {
            $results                = $this->dispatch(new StockRecalculate($this->transaction));
        }

        if(!isset($results))
        {
            $errors                 = $errors->add('Stock', 'Failed Recalculate Stock');
            $results                = new Jsend('error', (array)$this->transaction, (array)$errors);
        }

        return $results;
    }

    public function draft()
    {
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

        return $flag;
    }

    public function waiting()
    {
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

        return $flag;
    }

    public function paid()
    {
        $flag                       = false;

        $is_paid                    = $this->dispatch(new PaymentIsValid($this->transaction));

        if($is_paid->getStatus()=='success')
        {
            $flag                   = true;
        }

        $is_shipped                 = $this->dispatch(new ShippingNoted($this->transaction));

        if($is_shipped->getStatus()=='error')
        {
            $flag                   = true;
        }

        return $flag;
    }

    public function shipped()
    {
        $flag                       = false;

        $is_paid                    = $this->dispatch(new PaymentIsValid($this->transaction));

        if($is_paid->getStatus()=='success')
        {
            $flag                   = true;
        }

        $is_shipped                 = $this->dispatch(new ShippingNoted($this->transaction));

        if($is_shipped->getStatus()=='success')
        {
            $flag                   = true;
        }

        return $flag;
    }

    public function delivered()
    {
        $flag                       = false;

        $is_paid                    = $this->dispatch(new PaymentIsValid($this->transaction));

        if($is_paid->getStatus()=='success')
        {
            $flag                   = true;
        }

        $is_shipped                 = $this->dispatch(new ShippingNoted($this->transaction));

        if($is_shipped->getStatus()=='success')
        {
            $flag                   = true;
        }

        return $flag;
    }

    public function canceled()
    {
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

        return $flag;
    }
}
