<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;

class GenerateTransactionRefNumber extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction                    = $transaction;
    }

    public function handle()
    {
        switch ($this->transaction->status) 
        {
            case 'draft':
                $this->transaction->ref_number  = '0000000000';
                break;
            case 'waiting':
                $prefix                         = date("ymd");

                $latest_transaction             = Transaction::select('ref_number')
                                                    ->where('ref_number','like', $prefix . '%')
                                                    ->orderBy('ref_number', 'DESC')
                                                    ->first();


                if(empty($latest_transaction))
                {
                    $number                     = 1;
                }
                else
                {
                    $number                     = 1 + (int)substr($latest_transaction['ref_number'],6);
                }

                $ref_number                     = str_pad($number,4,"0",STR_PAD_LEFT);

                $this->transaction->ref_number  = $prefix . $ref_number;
                break;
            default:
                break;
        }

        return new jsend('success', (array)$this->transaction);
    }
}
