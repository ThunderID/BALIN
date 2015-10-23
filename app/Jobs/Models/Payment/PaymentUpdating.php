<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Payment;

class PaymentUpdating extends Job implements SelfHandling
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment                  = $payment;
    }
    
    public function handle()
    {
        $result                          = new jsend('success', (array)$this->transaction );
    }
}
