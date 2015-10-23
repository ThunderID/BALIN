<?php

namespace App\Jobs;

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
        if($this->payment->transaction_id)
        {
            $result                      = new jsend('error', (array)$this->transaction, ['message' => 'Tidak bisa menghapus data payment yang sudah divalidasi'] );
        }

        $result                          = new jsend('success', (array)$this->transaction );
    }
}
