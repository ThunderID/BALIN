<?php

namespace App\Jobs;

use App\Models\Transaction;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag;
use Auth, Session;

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

        $basket                                             = [];
        
        foreach ($this->transaction->transactiondetails as $key => $value) 
        {
            if(isset($basket[$value['product_id']]))
            {
                $basket[$value['product_id']]['varians'][$value->varian_id]  = ['varian_id' => $value->varian_id, 'qty' => $value->quantity, 'size' => $value->varian->size, 'stock' => $value->varian->stock];
            }
            elseif($value->varian)
            {
                $tempb                                      = [];
                $tempb['slug']                              = $value['varian']['product']['slug'];
                $tempb['name']                              = $value['varian']['product']['name'];
                $tempb['price']                             = $value['varian']['product']['price'];
                $tempb['discount']                          = $value['varian']['product']['discount'];
                $tempb['stock']                             = $value['varian']['product']['stock'];
                $tempb['images']                            = $value['varian']['product']['default_image'];
                $tempb['varians'][$value->varian_id]        = ['varian_id' => $value->varian_id, 'qty' => $value->quantity, 'size' => $value->varian->size, 'stock' => $value->varian->stock];

                $basket[$value->varian->product_id]         = $tempb;
            }
            else
            {
                if(!$value->delete())
                {
                    $result                                 = new JSend('error', (array)$basket, $value->getError());
                }
            }
        }

        Session::forget('baskets');
        $baskets                                           = Session::put('baskets', $basket);

        $result                                            = new JSend('success', (array)$basket);

        return $result;
    }
}
