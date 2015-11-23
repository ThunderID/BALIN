<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Models\TransactionDetail;

use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag;
use Auth;

class SaveToTransactionDetail extends Job implements SelfHandling
{
    protected $cart;

    public function __construct(Transaction $transaction, array $cart, array $price)
    {
        $this->cart                         = $cart;
        $this->transaction                  = $transaction;
        $this->price                        = $price;
    }

    public function handle()
    {
        $result                             = new JSend('success', (array)$this->cart);
        
        $errors                             = new MessageBag();

        foreach ($this->cart as $key => $value)
        {
            $prev                           = TransactionDetail::transactionid($this->transaction->id)->varianid($value['varian_id'])->first();

            if($prev)
            {
                $trsdetail                  = $prev;
            }
            else
            {
                $trsdetail                  = new TransactionDetail;
            }

            $trsdetail->fill([
                'transaction_id'        => $this->transaction['id'],
                'varian_id'             => $value['varian_id'],
                'quantity'              => $value['qty'],
                'price'                 => $this->price['price'],
                'discount'              => $this->price['discount'],
            ]);

            //cek apa punya error
            if(!$trsdetail->save())
            {
                $errors->add('Transaction', $trsdetail->getError());
            }
        } 

        if($errors->count())
        {
            $result                         = new JSend('error', (array)$this->cart, $errors);
        }

        return $result;
    }
}
