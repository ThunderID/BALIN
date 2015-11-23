<?php

namespace App\Jobs\Models\TransactionDetail;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\TransactionDetail;

class TransactionDetailDeleting extends Job implements SelfHandling
{
    protected $transactiondetail;

    public function __construct(TransactionDetail $transactiondetail)
    {
        $this->transactiondetail            = $transactiondetail;
    }

    public function handle()
    {
    	// if($this->transactiondetail->transaction->type=='buy')
    	// {
	    // 	$varian 						= TransactionDetail::varianid($this->transactiondetail->varian_id)->TransactionType('sell')->count();

	    // 	if($varian)
	    // 	{
		   //      return new JSend('error', (array)$this->transactiondetail, 'Tidak dapat menghapus transaksi restock barang yang sudah pernah dibeli pelanggan.' );
	    // 	}
    	// }

        return new JSend('success', (array)$this->transactiondetail );
    }
}
