<?php

namespace App\Jobs\Models\Product;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Product;
use Str;

class ProductSaving extends Job implements SelfHandling
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product                    = $product;
    }

    public function handle()
    {
        // $this->product->slug            = Str::slug($this->product->name);

        // $slug                           = Product::slug($this->product->slug)->notid($this->product->id)->first();

        // if(!is_null($slug))
        // {
        //     return new JSend('error', (array)$this->product, 'Produk sudah ada');
        // }

        return new JSend('success', (array)$this->product);
    }
}
