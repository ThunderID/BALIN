<?php

namespace App\Jobs;

/*
    Input   : Instance of transaction with transaction ID (exists transaction)
    Process : Count Reserved stock, current stock and on hold stock in based on transactions' products quantity + saved stock
    Output  : JSEND format, if errors will displayed errors with error message, if success return transaction model
*/

use App\Jobs\Job;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Policy;
use App\Models\PointLog;

use Illuminate\Contracts\Bus\SelfHandling;
use \Illuminate\Support\MessageBag as MessageBag;

use App\Libraries\JSend;

class AddingPoint extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        //
        $this->transaction          = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        $errors                     = new MessageBag;

        if(is_null($this->transaction->referral_code))
        {
            $result                 = new Jsend('success', (array)$this->transaction);
        }
        else
        {
            $customer               = User::active($this->transaction->referralcode)->first();
            $royalty                = Policy::type('referral_royalty')->ondate('now')->first();

            if($royalty && $customer)
            {
                $point              = new PointLog;
                $point->fill([
                        'transaction_id'               => $this->transaction->id,
                        'user_id'                      => $customer->id,
                        'debit'                        => $royalty->value,
                        'credit'                       => 0,
                        'expired_date'                 => date('Y-m-d H:i:s'),
                    ]);

                if($point->save())
                {
                    $result                             = new Jsend('success', (array)$this->transaction);
                }
                else
                {
                    $errors->add('Points', $point->getError());
                }
            }
        }

        if(!isset($result) && !$errors->count())
        {
            $errors->add('Points', 'Can not save point');
        }

        if($errors->count())
        {
            $result                 = new Jsend('error', (array)$this->transaction, (array)$errors);
        }

        return $result;
    }
}
