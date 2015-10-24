<?php

namespace App\Jobs\Models\Payment;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Payment;

class PaymentSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment                  = $payment;
    }

    public function handle()
    {
        $result                         = $this->dispatch(new SwitchPaymentTransaction($payment));

        return $result;
    }
}
