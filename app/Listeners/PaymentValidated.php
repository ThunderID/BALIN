<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use App\Models\Payment;
use App\Jobs\StockRecalculate;

class PaymentValidated
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
    public function handle(Payment $payment)
    {
        if($payment->transaction->status == 'paid')
        {
            $result					= $this->dispatch(new StockRecalculate($payment->transaction));
        }
        elseif($payment->transaction->status == 'shipping' && isset($payment->transaction->shipments))
        {
            $result                 = $this->dispatch(new StockRecalculate($payment->transaction));
        }
        elseif($payment->transaction->status == 'delivered' && isset($payment->transaction->shipments) && $payment->transaction->shipments[0]=='delivered')
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