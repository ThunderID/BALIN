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
        if($this->payment->transaction)
        {
            $result                     = $this->dispatch(new ReferralPointIsGiven($this->payment->transaction));

            if($result->getStatus()=='success')
            {
                $result                     = $this->dispatch(new SendPaymentEmail($this->payment->transaction));
            }
        }
        else
        {
            $result                         = new JSend('success', (array)$this->payment);
        }
            $result                         = new JSend('error', (array)$this->payment, 'invalid payment1');

        return $result;
    }
}
