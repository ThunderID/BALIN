<?php

namespace App\Jobs\Models\Voucher;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Voucher;

class VoucherUpdating extends Job implements SelfHandling
{
    protected $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher                 = $voucher;
    }

    public function handle()
    {
        if(isset($this->voucher->getDirty()['type']))
        {
            return new JSend('error', (array)$this->voucher, 'Tidak dapat mengubah tipe voucher.');
        }

        if($this->voucher->transactions()->count())
        {
            return new JSend('error', (array)$this->voucher, 'Tidak dapat mengubah voucher yang telah digunakan dalam transaksi.');
        }

        // foreach ($this->voucher->quotalogs as $key => $value) 
        // {
        //     if($value['amount'] < 0)
        //     {
        //         return new JSend('error', (array)$this->voucher, 'Tidak dapat mengubah voucher yang telah digunakan sebagai referral.');
        //     }
        // }

        return new JSend('success', (array)$this->voucher);
    }
}
