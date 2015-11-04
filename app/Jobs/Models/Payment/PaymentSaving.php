<?php

namespace App\Jobs\Models\Payment;

use App\Jobs\Job;
use App\Jobs\CheckPaid;
use App\Jobs\ChangeStatus;
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
            $result                         = $this->dispatch(new CheckPaid($this->payment->transaction, $this->payment));
        }
        else
        {
            $result                         = new JSend('success', (array)$this->payment);
        }
        
        return $result;
    }
}
