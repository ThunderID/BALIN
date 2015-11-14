<?php

namespace App\Jobs;

use App\Models\Transaction;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag;
use Auth, Cookie;

class SaveToCookie extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                                  = $transaction;
    }

    public function handle()
    {
        $result                                             = new JSend('success', (array)$this->transaction);

        $errors                                             = new MessageBag();

        $basket                                             = null;
        
        foreach ($this->transaction->transactiondetails as $key => $value) 
        {
            if(isset($basket[$value['product_id']]))
            {
                $basket[$value['product_id']]['varians'][]  = ['varian_id' => $value->varian_id, 'qty' => $value->quantity, 'size' => $value->varian->size, 'stock' => $value->varian->stock];
            }
            else
            {
                $tempb['slug']                             = $value['varian']['product']['slug'];
                $tempb['name']                             = $value['varian']['product']['name'];
                $tempb['price']                            = $value['varian']['product']['price'];
                $tempb['discount']                         = $value['varian']['product']['discount'];
                $tempb['stock']                            = $value['varian']['product']['stock'];
                $tempb['images']                           = $value['varian']['product']['default_image'];
                $tempb['varians'][]                        = ['varian_id' => $value->varian_id, 'qty' => $value->quantity, 'size' => $value->varian->size, 'stock' => $value->varian->stock];

                $basket[$value['product_id']]              = $tempb;
            }
        }

        Cookie::forget('baskets');
        $baskets                                           = Cookie::make('baskets', $basket, 1440);

        $result                                            = new JSend('success', (array)$basket);

        return $result;
    }
}
