<?php

namespace App\Jobs\Models\Varian;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Varian;

class VarianUpdating extends Job implements SelfHandling
{
    protected $varian;

    public function __construct(Varian $varian)
    {
        $this->varian             = $varian;
    }

    public function handle()
    {
		if($this->varian->transactiondetails->count())
        {
            return new JSend('error', (array)$this->varian, 'Tidak dapat mengubah varian yang memiliki transaksi.');
        }

        return new JSend('success', (array)$this->varian);
    }
}
