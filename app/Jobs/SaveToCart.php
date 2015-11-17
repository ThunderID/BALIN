<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Models\TransactionDetail;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag;
use Auth;

class SaveToCart extends Job implements SelfHandling
{
    protected $cart;

    public function __construct(array $cart)
    {
        $this->cart                         = $cart;
    }

    public function handle()
    {
        $result                             = new JSend('success', (array)$this->cart);

        $errors                             = new MessageBag();
        
        $transaction                        = new Transaction;

        $transaction->fill([
                    'user_id'               => Auth::user()->id,
                    'type'                  => 'sell',
                    ]);

        if($transaction->save())
        {
            foreach ($this->cart as $key => $cart) 
            {
                foreach ($cart['varians'] as $key => $value)
                {
                    $trsdetail                  = new TransactionDetail;

                    $trsdetail->fill([
                        'transaction_id'        => $transaction['id'],
                        'varian_id'             => $value['varian_id'],
                        'quantity'              => $value['qty'],
                        'price'                 => $cart['price'],
                        'discount'              => $cart['discount'],
                    ]);

                    //cek apa punya error
                    if(!$trsdetail->save())
                    {
                        $errors->add('Transaction', $trsdetail->getError());
                    }
                } 
            }
        }
        else
        {
            $errors->add('Transaction', $transaction->getError());
        }

        if($errors->count())
        {
            dd($errors);
            $result                         = new JSend('error', (array)$this->cart, $errors);
        }

        return $result;
    }
}
