<?php

namespace App\Jobs;

/*
    Input   : Instance of transaction with transaction ID (exists transaction)
    Process : Count Reserved stock, current stock and on hold stock in based on transactions' products quantity + saved stock
    Output  : JSEND format, if errors will displayed errors with error message, if success return transaction model
*/

use App\Jobs\Job;
use App\Models\Shipment;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag as MessageBag;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;

class TrackOrderShipment extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Shipment $shipment)
    {
        //
        $this->shipment          = $shipment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if(is_null($this->shipment->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $errors                     = new MessageBag;
        $result                     = false;

        switch ($this->shipment->transaction->status) 
        {
            case 'draft': case 'canceled': case 'shipped': case 'waiting': case 'delivered':
                break;
            case 'paid':
                if($this->shipment->receipt_number)
                {
                    $result         = $this->dispatch(new TrackShippedShipment($this->shipment->transaction));
                }
                else
                {
                    $result         = new jsend('success', (array)$this->transaction);
                }
                break;
            default:
                throw new Exception('Transaction status invalid.');
                break;
        }

        if(!isset($results))
        {
            $errors                 = $errors->add('Stock', 'Shipment Invalid');
            $results                = new Jsend('error', (array)$this->shipment, (array)$errors);
        }

        return $results;
    }
}
