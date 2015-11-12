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
        // get product varian's transaction
        $Products                           = product::where('id', $this->product->id)->with('TransactionDetails')->first();

        $TransactionDetails                 = count($Products['TransactionDetails']);

        //count transaction if any then fails
        if($TransactionDetails > 0)
        {
            return new JSend('error', (array)$this->product, 'Tidak bisa edit data produk yang telah memiliki transaksi');
        }

        return new JSend('success', (array)$this->product);
    }
}
