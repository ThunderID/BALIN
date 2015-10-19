<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Payment;


class PaymentSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //
    }

    public function handle(Payment $payment)
    {
        $result                         = $this->dispatch(new SwitchPaymentTransaction($payment));

        return $result;
    }
}
