<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use App\Models\Shipment;
use App\Jobs\SwitchShipmentTransaction;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ShipmentSaved
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Session  $event
     * @return void
     */
    public function handle(Shipment $Shipment)
    {
        $result                         = $this->dispatch(new SwitchShipmentTransaction($Shipment));

        return $result;
    }
}