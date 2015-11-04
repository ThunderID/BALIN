<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;
use App\Models\StoreSetting;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;

class SendPaymentEmail extends Job implements SelfHandling
{
    use DispatchesJobs;
    
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction             = $transaction;
    }

    public function handle()
    {
        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $transaction    = Transaction::id($this->transaction->id)->with(['payment', 'user'])->first();

        $info           = StoreSetting::storeinfo(true)->take(8)->get();
        $infos          = [];

        foreach ($info as $key => $value) 
        {
            $infos[$value->type]    = $value->value;
        }

        $datas          = ['paid' => $transaction, 'balin' => $infos];

        $mail_data      = [
                            'view'          => 'emails.paid', 
                            'datas'         => $datas,
                            'dest_email'    => $transaction['user']['email'], 
                            'dest_name'     => $transaction['user']['name'], 
                            'subject'       => 'BALIN - Payment Validation', 
                        ];

        // call email send job
        $this->dispatch(new Mailman($mail_data));

        return new JSend('success', (array)$this->transaction);           
    } 
}
