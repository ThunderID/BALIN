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
        if($this->payment->transaction)
        {
            $result                      = new JSend('error', (array)$this->payment, 'Tidak bisa menghapus data payment yang sudah divalidasi');
        }

        $result                          = new JSend('success', (array)$this->payment);

        return $result;
    }
}
