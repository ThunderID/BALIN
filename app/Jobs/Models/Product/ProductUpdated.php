<?php

namespace App\Jobs\Models\Product;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Product;

class ProductUpdated extends Job implements SelfHandling
{
    protected $product;

    public function __construct(product $product)
    {
        $this->product                  = $product;
    }


    public function handle()
    {
        return new JSend('success', (array)$this->product);
    }
}
