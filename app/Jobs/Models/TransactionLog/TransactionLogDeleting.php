<?php

namespace App\Jobs\Models\TransactionLog;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\TransactionLog;

class TransactionLogDeleting extends Job implements SelfHandling
{
    protected $transactionlog;

    public function __construct(TransactionLog $transactionlog)
    {
        $this->transactionlog            	= $transactionlog;
    }

    public function handle()
    {
        if($this->transactionlog->transaction->type=='buy')
        {
            $result                         = new JSend('success', (array)$this->transactionlog);
        }
        else
        {
            $result                         = new JSend('error', (array)$this->transactionlog, 'Tidak dapat menghapus transaksi.');
        }

		return $result;
    }
}
