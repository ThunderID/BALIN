<?php

namespace App\Jobs;

use App\Libraries\JSend;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;
use App\Models\Policy;

class GenerateTransactionUniqNumber extends Job implements SelfHandling
{
    protected $transaction; 

    public function __construct(Transaction $transaction)
    {
        $this->transaction              = $transaction;
    }


    public function handle()
    {
        try
        {
            if(!is_null($this->transaction->unique_number))
            {
                $prev_number            = Transaction::orderBy('id', 'DESC')->first();

                $limit                  = Policy::type('limit_unique_number')->first();

                if($prev_number['unique_number'] < $limit['value'])
                {
                    $unique_number      = $prev_number['unique_number'] + 1;
                }
                else
                {
                    $unique_number      = 1;
                }

                $this->transaction->unique_number    = $unique_number  ;
            }

            $result                     = new JSend('success', (array)$this->transaction);
        } 
        catch (Exception $e) 
        {
            $result                     = new JSend('fail', (array)$this->transaction, (array)$e);
        }  

        return $result;
    }
}
