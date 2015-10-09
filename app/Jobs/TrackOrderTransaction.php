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
                $result             = $this->dispatch(new TrackDraftOrder($this->transaction));
                break;
            case 'waiting':
                $result             = $this->dispatch(new TrackWaitingOrder($this->transaction));
                break;
            case 'paid':
                $result             = $this->dispatch(new TrackPaidOrder($this->transaction));
                break;
            case 'shipped':
                $result             = $this->dispatch(new TrackShippedOrder($this->transaction));
                break;
            case 'delivered':
                $result             = $this->dispatch(new TrackDeliveredOrder($this->transaction));
                break;
            case 'canceled':
                $result             = $this->dispatch(new TrackCanceledOrder($this->transaction));
                break;
            default:
                throw new Exception('Transaction status invalid.');
                break;
        }

        if(!isset($results))
        {
            $errors                 = $errors->add('Stock', 'Failed Recalculate Stock');
            $results                = new Jsend('error', (array)$this->transaction, (array)$errors);
        }

        return $results;
    }
}
