<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use App\Models\Payment;
use App\Jobs\SwitchPaymentTransaction;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PaymentSaved
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
    public function handle(Payment $payment)
    {
        $result                         = $this->dispatch(new SwitchPaymentTransaction($payment));

        return $result;
    }
}