<?php

namespace App\Jobs\Models\Price;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Price;

class PriceSaving extends Job implements SelfHandling
{
    protected $price;

    public function __construct(Price $price)
    {
        $this->price                    = $price;
    }

    public function handle()
    {
        if($this->price->started_at)
        {
            if(date('Y-m-d H:i:s') >= $this->price->started_at)
            {
                return new JSend('error', (array)$this->price, 'Tidak bisa menyimpan harga tertanggal sebelum hari ini');
            }
        }

        return new JSend('success', (array)$this->price);
    }
}
