<?php

namespace App\Jobs\Models\TransactionDetail;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\TransactionDetail;

class TransactionDetailSaving extends Job implements SelfHandling
{
    protected $transactiondetail;

    public function __construct(TransactionDetail $transactiondetail)
    {
        $this->transactiondetail            = $transactiondetail;
    }

    public function handle()
    {
        if($this->transactiondetail->transaction->status=='cart' || $this->transactiondetail->transaction->type=='buy')
    	{
	        return new JSend('success', (array)$this->transactiondetail );
    	}
    	else
    	{
	        return new JSend('error', (array)$this->transactiondetail, 'Tidak dapat menambahkan item baru. Silahkan membuat nota baru.' );
    	}
    }
}
