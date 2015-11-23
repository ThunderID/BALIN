<?php

namespace App\Jobs\Models\Voucher;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Voucher;

class VoucherSaving extends Job implements SelfHandling
{
    protected $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher                 = $voucher;
    }

    public function handle()
    {
        if($this->voucher->type=='referral' && ($this->voucher->user_id==0 || !is_null($this->voucher->started_at) || !is_null($this->voucher->expired_at)))
        {
            return new JSend('error', (array)$this->voucher, 'Voucher referral hanya dapat digunakan untuk pelanggan dan tanpa batas waktu.');
        }

        if($this->voucher->user()->count())
        {
            $prevvocuher                = Voucher::userid($this->voucher->user_id)->notid($this->voucher->id)->first();

            if($prevvocuher)
            {
                return new JSend('error', (array)$this->voucher, 'User sudah memiliki referral code.');
            }

            $this->voucher->type        = 'referral';
        }

		if($this->voucher->transactions->count())
		{
			return new JSend('error', (array)$this->voucher, 'Tidak dapat mengubah voucher yang telah digunakan dalam transaksi.');
		}

		return new JSend('success', (array)$this->voucher);

    }
}
