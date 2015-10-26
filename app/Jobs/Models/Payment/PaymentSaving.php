<?php

namespace App\Jobs\Models\Payment;

use App\Jobs\Job;
use App\Jobs\PaymentIsValid;
use App\Jobs\ReferralPointIsGiven;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Libraries\JSend;

use App\Models\Payment;

class PaymentSaving extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment                  = $payment;
    }
    
    public function handle()
    {
        if($this->payment->transaction)
        {
            $result                         = $this->dispatch(new PaymentIsValid($this->payment->transaction, $this->payment));
        }
        else
        {
            $result                         = new JSend('success', (array)$this->payment);
        }
        
        return $result;
    }
}
