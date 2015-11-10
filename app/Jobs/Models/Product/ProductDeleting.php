<?php

namespace App\Jobs\Models\Product;

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
        // if($this->product->transactiondetails->count())
        // {
        //     return new JSend('error', (array)$this->product, 'Produk memiliki transaksi');
        // }

        return new JSend('success', (array)$this->product);
    }
}
