<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Product;

class ProductDeleting extends Job implements SelfHandling
{
    protected $product;

    public function __construct(product $product)
    {
        $this->product                  = $product;
    }


    public function handle()
    {
        if($this->product->transactiondetails->count())
        {
            return new jsend('error', (array)$this->product, ['message' => 'Produk memiliki transaksi']);
        }

        return new jsend('success', (array)$this->product);
    }
}
