<?php

namespace App\Jobs\Models\Shipment;

use App\Jobs\Job;
use App\Jobs\SendShipmentEmail;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Shipment;
use App\Models\Transaction;
use App\Libraries\JSend;

class ShipmentSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment                 = $shipment;
    }

    public function handle()
    {
        if(is_null($this->shipment->receipt_number))
        {
            $result                 = new JSend('success', (array)$this->shipment);
        }
        else
        {
            $transaction            = Transaction::findorfail($this->shipment->transaction_id);

            $transaction->fill(['status' => 'shipped']);

            if($transaction->save())
            {
                $result             = $this->dispatch(new SendShipmentEmail($this->shipment->transaction));
            }
            else
            {
                $result             = new JSend('error', (array)$this->shipment, $transaction->getError());
            }
        }

        return $result;
    }
}
