<?php

namespace App\Jobs\Models\TransactionLog;

use App\Jobs\Job;
use App\Jobs\Mailman;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Models\TransactionLog;
use App\Models\Transaction;
use App\Models\User;

use App\Jobs\CreditPoint;
use App\Jobs\RevertPoint;
use App\Jobs\ChangeStatus;
use App\Jobs\SaveAuditor;
use App\Jobs\AddQuotaForUpline;
use App\Jobs\AddPointForUpline;
use App\Jobs\SendBillingEmail;
use App\Jobs\SendPaymentEmail;
use App\Jobs\SendShipmentEmail;
use App\Jobs\SendDeliveredEmail;
use App\Jobs\SendCanceledEmail;

use App\Jobs\Auditors\SaveAuditAbandonCart;
use App\Jobs\Auditors\SaveAuditPayment;
use App\Jobs\Auditors\SaveAuditShipment;
use App\Jobs\Auditors\SaveAuditCanceled;
use App\Jobs\Auditors\SaveAuditDelivered;

use App, Carbon;


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
        $transaction            =  Transaction::findorfail($this->transactionlog->transaction->id);

        if(!$transaction->save())
        {
            return new JSend('error', (array)$this->transactionlog, $transaction->getError() );
        }

        if($this->transactionlog->transaction->type=='sell')
        {
            switch($this->transactionlog->status)
            {
                case 'cart' :
                    $result                     = $this->dispatch(new SaveAuditAbandonCart($this->transactionlog->transaction));
                break;
                case 'wait' :
                    $result                     = $this->dispatch(new CreditPoint(Transaction::id($this->transactionlog->transaction_id)->first()));
                    if($result->getStatus()=='success')
                    {
                        $transaction_tmp        = Transaction::id($this->transactionlog->transaction_id)->first();

                        $datas                  =   [   
                                                        'name'          => User::find($transaction_tmp->user_id)['name'],
                                                        'date'          => $transaction_tmp->transact_at,
                                                        'resi'          => $transaction_tmp->ref_number,
                                                    ];


                        //get default help balin address from env
                        $dest = env('DEFAULT_MAIL', 'help@balin.id');

                        $mail_data              =   [
                                                        'view'          => 'emails.userCheckout', 
                                                        'datas'         => $datas,
                                                        'dest_email'    => $dest, 
                                                        'dest_name'     => 'Balin Admin', 
                                                        'subject'       => 'BALIN - Customer Checkout', 
                                                    ];

                        $result                 = $this->dispatch(new Mailman($mail_data));

                        $result                 = $this->dispatch(new SendBillingEmail($this->transactionlog->transaction));
                    }

                    if($result->getStatus()=='success')
                    {
                        if($this->transactionlog->transaction->amount==0)
                        {
                            $result             = $this->dispatch(new ChangeStatus($this->transactionlog->transaction, 'paid'));
                        }
                    }
                break;
                case 'paid' :
                    $result                     = $this->dispatch(new AddQuotaForUpline($this->transactionlog->transaction));
                    if($result->getStatus()=='success')
                    {
                        $result                 = $this->dispatch(new AddPointForUpline($this->transactionlog->transaction));
                    }
                    if($result->getStatus()=='success')
                    {
                        $result                 = $this->dispatch(new SendPaymentEmail($this->transactionlog->transaction));
                    }
                    if($result->getStatus()=='success')
                    {
                        $result                 = $this->dispatch(new SaveAuditPayment($this->transactionlog->transaction));
                    }
                break;
                case 'shipping' :
                    $result                     = $this->dispatch(new SendShipmentEmail($this->transactionlog->transaction));
                    if($result->getStatus()=='success')
                    {
                        $result                 = $this->dispatch(new SaveAuditShipment($this->transactionlog->transaction));
                    }
                break;
                case 'delivered' :
                    $result                     = $this->dispatch(new SendDeliveredEmail($this->transactionlog->transaction));
                    if($result->getStatus()=='success')
                    {
                        $result                 = $this->dispatch(new SaveAuditDelivered($this->transactionlog->transaction));
                    }
                break;
                case 'canceled' :
                    $result                     = $this->dispatch(new RevertPoint($this->transactionlog->transaction));
                    if($result->getStatus()=='success')
                    {
                        $result                 = $this->dispatch(new SendCanceledEmail($this->transactionlog->transaction));
                    }
                    if($result->getStatus()=='success')
                    {
                        $result                 = $this->dispatch(new SaveAuditCanceled($this->transactionlog->transaction));
                    }
                break;
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
