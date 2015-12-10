<?php

namespace App\Jobs\Models\TransactionLog;

use App\Jobs\Job;
use App\Jobs\CheckStock;
use App\Jobs\CheckAddress;
use App\Jobs\CheckPaid;
use App\Jobs\CheckShipping;

use App\Jobs\Models\Transaction\Sell\TransactionSellSaving;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\TransactionLog;
use App\Models\Payment;

class TransactionLogSaving extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $transactionlog;

    public function __construct(TransactionLog $transactionlog)
    {
        $this->transactionlog               = $transactionlog;
    }

    public function handle()
    {
        $result                             = new JSend('success', (array)$this->transactionlog );

        if($this->transactionlog->transaction->type=='sell' && !in_array($this->transactionlog->transaction->status, ['canceled', 'abandoned', 'delivered']))
        {
            switch($this->transactionlog->status)
            {
                case 'abandoned' :
                    if($this->transactionlog->transaction->status!='cart')
                    {
                       $result              = new JSend('error', (array)$this->transactionlog, 'Tidak dapat mengabaikan transaksi yang bukan di keranjang.');
                    }
                break;
                case 'cart' :
                    if($this->transactionlog->transaction->status!='cart' && $this->transactionlog->transaction->status!='na')
                    {
                       $result              = new JSend('error', (array)$this->transactionlog, 'Tidak dapat mengabaikan transaksi yang sudah checkout.');
                    }
                break;
                case 'wait' :
                    $result                 = $this->dispatch(new CheckStock($this->transactionlog->transaction));
                    if($result->getStatus()=='success')
                    {
                        $result             = $this->dispatch(new CheckAddress($this->transactionlog->transaction));
                    }
                break;
                case 'paid' : case 'packed' :
                    if(in_array($this->transactionlog->transaction->status, ['cart']))
                    {
                       $result              = new JSend('error', (array)$this->transactionlog, 'Tidak dapat memvalidasi transaksi yang bukan belum di checkout.');
                    }

                    if($result->getStatus()=='success')
                    {
                        $result             = $this->dispatch(new CheckPaid($this->transactionlog->transaction, new Payment));
                    }
                break;
                case 'shipping': case 'delivered' :
                    $result                 = $this->dispatch(new CheckPaid($this->transactionlog->transaction, new Payment));
                    if($result->getStatus()=='success')
                    {
                        $result             = $this->dispatch(new CheckShipping($this->transactionlog->transaction));
                    }
                break;
                case 'canceled' :
                    $result                 = $this->dispatch(new CheckPaid($this->transactionlog->transaction, new Payment));
                    if($result->getStatus()=='success')
                    {
                        $result             = new JSend('error', (array)$this->transactionlog, 'Tidak dapat membatalkan transaksi yang sudah dibayar.');
                    }
                    elseif($this->transactionlog->transaction->status!='wait')
                    {
                       $result              = new JSend('error', (array)$this->transactionlog, 'Tidak dapat mengabaikan transaksi yang bukan belum di checkout.');
                    }
                    else
                    {
                        $result             = new JSend('success', (array)$this->transactionlog );
                    }
                break;
            }
        }

        return $result;
    }
}
