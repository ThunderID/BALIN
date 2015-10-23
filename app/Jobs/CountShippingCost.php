<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\shipment;
use App\Models\ShippingCost;

class CountShippingCost extends Job implements SelfHandling
{
    protected $shipment;

    public function __construct(shipment $shipment)
    {
        $this->shipment                 = $shipment;
    }

    public function handle()
    {
        if(is_null($this->shipment->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $shippingCost                   = shippingCost::where('courier_id',$this->shipment->courier_id)
                                            ->where('start_postal_code','<=',$this->shipment->zipcode)
                                            ->where('end_postal_code','>=',$this->shipment->zipcode)
                                            ->orderBy('start_date', 'DESC')
                                            ->first()
                                            ;

        if(empty($shippingCost))
        {
            return new json('error', (array)$this->shipment, ['message' => 'Data not found']);
        }

        return new json('success', (array)$shippingCost );
    }
}
