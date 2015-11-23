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

        return new JSend('success', (array)$this->voucher);
    }
}
