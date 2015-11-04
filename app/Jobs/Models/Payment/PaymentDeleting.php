<?php

namespace App\Jobs\Models\Payment;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Payment;

class PaymentDeleting extends Job implements SelfHandling
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment                  = $payment;
    }
    
    public function handle()
    {
        $result                          = new JSend('success', (array)$this->payment);

        if($this->payment->transaction->count())
        {
            $result                      = new JSend('error', (array)$this->payment, 'Tidak bisa menghapus data payment yang sudah divalidasi.');
        }

        return $result;
    }
}
