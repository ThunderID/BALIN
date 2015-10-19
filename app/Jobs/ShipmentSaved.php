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

    public function __construct()
    {
        //
    }

    public function handle(Shipment $Shipment)
    {
        $result                         = $this->dispatch(new SwitchShipmentTransaction($Shipment));

        return $result;
    }
}
