<?php

namespace App\Jobs\Models\Payment;

use App\Jobs\Job;
use App\Jobs\PaymentIsValid;
use App\Jobs\ReferralPointIsGiven;
use App\Jobs\SendPaymentEmail;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\Payment;
use App\Libraries\JSend;

class PaymentSaved extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment                      = $payment;
    }

    public function handle()
    {
        $result                             = new JSend('success', (array)$this->payment);

        return $result;
    }
}
