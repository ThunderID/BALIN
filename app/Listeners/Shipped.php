<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use App\Models\Shipment;
use App\Jobs\StockRecalculate;

class Shipped
{
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
    public function handle(Shipment $shipment)
    {
        if($shipment->transaction->status == 'shipping' && isset($shipment->transaction->payments))
        {
            $result					= $this->dispatch(new StockRecalculate($shipment->transaction));
        }
        elseif($shipment->transaction->status == 'paid' && isset($payment->transaction->payments))
        {
            $result                 = $this->dispatch(new StockRecalculate($payment->transaction));
        }
        elseif($shipment->transaction->status == 'delivered' && isset($payment->transaction->payments) && $shipment->status == 'delivered')
        {
            $result                 = $this->dispatch(new StockRecalculate($payment->transaction));
        }
        else
        {
            return false;
        }
 
        return $result;
    }
}