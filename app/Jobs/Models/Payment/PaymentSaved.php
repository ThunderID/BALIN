<?php

namespace App\Jobs\Models\Payment;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Payment;
use App\Libraries\JSend;

class PaymentSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment                      = $payment;
    }

    public function handle()
    {
        if($this->payment->transaction_id!=0)
        {
            $result                         = $this->dispatch(new SwitchPaymentTransaction($this->payment));
        }
        else
        {
            $result                         = new JSend('success', (array)$this->payment);
        }

        return $result;
    }
}
