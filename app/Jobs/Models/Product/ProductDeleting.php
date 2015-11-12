<?php

namespace App\Jobs\Models\Product;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Libraries\JSend;

use App\Models\Product;
use App\Models\Varian;
use App\Models\Price;
use App\Models\Image;
use App\Models\Lable;
use App\Models\CategoryProduct;

class ProductDeleting extends Job implements SelfHandling
{
    protected $product;

    public function __construct(product $product)
    {
        $this->product                  = $product;
    }


    public function handle()
    {
        //delete product's varian

        $varians                        = Varian::where('product_id', $this->product->id)->get();

        foreach ($varians as $varian) 
        {
            if(!$varian->delete())
            {
                return new JSend('error', (array)$this->product, (array)$varian->geterror() );
            }                     
        }

        //delete product's price
        $prices                        = Price::where('product_id', $this->product->id)->get();

        foreach ($prices as $price) 
        {
            if(!$price->delete())
            {
                return new JSend('error', (array)$this->product, (array)$price->geterror() );
            }                     
        }

        //delete product's image
        $images                        = Image::where('imageable_type','App\Models\Product')->where('imageable_id', $this->product->id)->get();

        foreach ($images as $image) 
        {
            if(!$image->delete())
            {
                return new JSend('error', (array)$this->product, (array)$image->geterror() );
            }                     
        }
        //delete product's lable
        $lables                        = Lable::where('product_id', $this->product->id)->get();

        foreach ($lables as $lable) 
        {
            if(!$lable->delete())
            {
                return new JSend('error', (array)$this->product, (array)$lable->geterror() );
            }                     
        }

        //delete product's categories
        $categories                     = CategoryProduct::where('product_id', $this->product->id)->get();

        foreach ($categories as $category) 
        {
            if(!$category->delete())
            {
                return new JSend('error', (array)$this->product, (array)$category->geterror() );
            }                     
        }


        return new JSend('success', (array)$this->product);
    }
}
