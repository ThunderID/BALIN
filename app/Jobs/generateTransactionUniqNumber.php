<?php

namespace App\Jobs;

use App\Libraries\JSend;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;
use App\Models\policy;

class generateTransactionUniqNumber extends Job implements SelfHandling
{
    protected $transaction; 

    public function __construct(transaction $transaction)
    {
        $this->transaction              = $transaction;
    }


    public function handle()
    {
        try
        {
            if(!is_null($this->transaction->unique_number))
            {
                $prev_number            = transaction::orderBy('id', 'DESC')->first();

                $limit                  = policy::type('limit_unique_number')->first();

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

            $result                     = new Jsend('success', ['message' => 'Expired date added']);
        } 
        catch (Exception $e) 
        {
            $result                     = new Jsend('fail', (array)$e);
        }  

        return $result;
    }
}
