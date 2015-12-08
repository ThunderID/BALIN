<?php

namespace App\Jobs\Models\Product;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Product;

class ProductUpdating extends Job implements SelfHandling
{
    protected $product;

    public function __construct(product $product)
    {
        $this->product                      = $product;
    }

    public function handle()
    {
        //count transaction if any then fails
        // if($this->product->transactiondetails()->count() > 0)
        // {
        //     return new JSend('error', (array)$this->product, 'Tidak bisa edit data produk yang telah memiliki transaksi');
        // }

        return new JSend('success', (array)$this->product);
    }
}
