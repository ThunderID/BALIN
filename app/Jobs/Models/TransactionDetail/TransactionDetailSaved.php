<?php

namespace App\Jobs\Models\TransactionDetail;

use App\Jobs\Models\TransactionDetail\Buy\TransactionDetailBuySaved;
use App\Jobs\Models\TransactionDetail\Sell\TransactionDetailSellSaved;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionDetailSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $transactiondetail;

    public function __construct(TransactionDetail $transactiondetail)
    {
        $this->transactiondetail            = $transactiondetail;
    }

    public function handle()
    {
        switch ($this->transactiondetail->transaction->type) 
        {
            case 'buy':
                $result                     = $this->dispatch(new TransactionDetailBuySaved($this->transactiondetail));
                break;
            
            default:
                $result                     = $this->dispatch(new TransactionDetailSellSaved($this->transactiondetail));
                break;
        }

        return $result;
    }    
}
