<?php

namespace App\Listeners;

use App\Jobs;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Shipment;

class ShipmentSaved
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