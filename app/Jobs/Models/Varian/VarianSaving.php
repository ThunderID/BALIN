<?php

namespace App\Jobs\Models\Varian;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Varian;

class VarianSaving extends Job implements SelfHandling
{
    protected $varian;

    public function __construct(Varian $varian)
    {
        $this->varian               = $varian;
    }

    public function handle()
    {
        $sku                        = Varian::sku($this->varian->sku)->notid($this->varian->id)->first();

        if(!is_null($sku))
        {
            return new JSend('error', (array)$this->varian, 'SKU sudah ada.');
        }

	    $result 			        =  new JSend('success', (array)$this->varian);

        return $result;
    }
}
