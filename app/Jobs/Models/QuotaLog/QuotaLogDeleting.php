<?php

namespace App\Jobs\Models\QuotaLog;

use App\Jobs\Job;
use App\Libraries\JSend;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\QuotaLog;

class QuotaLogDeleting extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $quotalog;

    public function __construct(QuotaLog $quotalog)
    {
        $this->quotalog             = $quotalog;
    }


    public function handle()
    {
        $result                     = new JSend('success', (array)$this->quotalog);

        if($this->quotalog->voucher->transactions()->count())
        {
            $result                 = new JSend('error', (array)$this->quotalog, 'Tidak dapat menghapus quota voucher yang telah digunakan dalam transaksi. Silahkan kurangi quota secara manual.');
        }

        if($this->quotalog->voucher->user()->count())
        {
            $result                 = new JSend('error', (array)$this->quotalog, 'Tidak dapat menghapus quota voucher yang telah digunakan dalam transaksi. Silahkan kurangi quota secara manual.');
        }

        return $result;
    }
}
