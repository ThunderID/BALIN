<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Price;

class PriceSaved extends Job implements SelfHandling
{
    protected $price;

    public function __construct(price $price)
    {
        $this->price                    = $price;
    }

    public function handle()
    {
        if(date('Y-m-d H:i:s', strtotime('now') >= $this->price->started_at)
        {
            return new jsend('error', (array)$this->price, ['message' => 'Tidak bisa edit harga yang telah dimulai']);
        }

        return new jsend('success', (array)$this->price);
    }
}
