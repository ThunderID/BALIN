<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Price;

class PriceDeleting extends Job implements SelfHandling
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
            return new jsend('error', (array)$this->price, ['message' => 'Tidak bisa hapus harga yang telah dimulai']);
        }

        return new jsend('success', (array)$this->product);
    }
}
