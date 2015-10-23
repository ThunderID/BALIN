<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Shipment;

class ShipmentSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $shipment;

    public function __construct(shipment $shipment)
    {
        $this->shipment                 = $shipment;
    }

    public function handle()
    {
        $result                         = $this->dispatch(new SwitchShipmentTransaction($Shipment));

        return $result;
    }
}
