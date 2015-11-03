<?php

namespace App\Jobs\Models\TransactionLog;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\TransactionLog;

use App\Jobs\CreditPoint;
use App\Jobs\RevertPoint;
use App\Jobs\SendBillingEmail;
use App\Jobs\SendPaymentEmail;
use App\Jobs\SendShipmentEmail;
use App\Jobs\SendDeliveredEmail;

class TransactionLogSaved extends Job implements SelfHandling
{
    use DispatchesJobs;

    protected $transactionlog;

    public function __construct(TransactionLog $transactionlog)
    {
        $this->transactionlog            = $transactionlog;
    }

    public function handle()
    {
        if($this->transactionlog->transaction->type=='sell')
        {
            switch($this->transactionlog->status)
            {
                case 'wait' :
                    $result                     = $this->dispatch(new CreditPoint($this->transactionlog->transaction));
                    
                    // if($result->getStatus()=='success')
                    // {
                    //     $result                 = $this->dispatch(new SendBillingEmail($this->transactionlog->transaction));
                    // }
                break;
                // case 'paid' :
                //     $result                     = $this->dispatch(new SendPaymentEmail($this->transactionlog->transaction));
                // break;
                // case 'shipping' :
                //     $result                     = $this->dispatch(new SendShipmentEmail($this->transactionlog->transaction));
                // break;
                // case 'delivered' :
                //     $result                     = $this->dispatch(new SendDeliveredEmail($this->transactionlog->transaction));
                // break;
                // case 'canceled' :
                    // $result                     = $this->dispatch(new RevertPoint($this->transactionlog->transaction));
                    // if($result->getStatus()=='success')
                    // {
                    //     $result                 = $this->dispatch(new SendCanceledEmail($this->transactionlog->transaction));
                    // }
                // break;
                default :
                    $result                     = new JSend('success', (array)$this->transactionlog );
                break;
            }
        }
        else
        {
            $result                             = new JSend('success', (array)$this->transactionlog );
        }

        return $result;
    }    
}
