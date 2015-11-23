<?php

namespace App\Jobs\Models\Voucher;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Voucher;

class VoucherDeleting extends Job implements SelfHandling
{
    protected $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher                 = $voucher;
    }

    public function handle()
    {
        if($this->voucher->user()->count())
        {
            return new JSend('error', (array)$this->voucher, 'Tidak dapat menghapus voucher referral.');
        }

		if($this->voucher->transactions()->count())
		{
			return new JSend('error', (array)$this->voucher, 'Tidak dapat menghapus voucher yang telah digunakan dalam transaksi.');
		}

        foreach ($this->voucher->quotalogs as $key => $value) 
        {
            if(!$value->delete())
            {
                return new JSend('error', (array)$this->voucher, $value->getError());
            }
        }

		return new JSend('success', (array)$this->voucher);
    }
}
