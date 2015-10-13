<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\JSend;
use App\Models\policy;
use App\Models\transaction;
use Illuminate\Contracts\Bus\SelfHandling;
use Exception, carbon;

class TransactionIsExpired extends Job implements SelfHandling
{
    protected $transaction;

    public function __construct(transaction $transaction)
    {
        $this->transaction              = $transaction;
    }

    public function handle()
    {
        // checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //get case status transaction
        $transac_date           = $this->transaction['transacted_at'];

        switch ($this->transaction['status']) 
        {
            case 'waiting':
                $exp_date       = $this->getExpiredFromSetting('expired_draft');
                $result         = $this->checkIsExpired($exp_date['value'], $transac_date);
                break;
            case 'paid':
                $exp_date       = $this->getExpiredFromSetting('expired_paid');
                $result         = $this->checkIsExpired($exp_date['value'], $transac_date);
                break;
            case 'shipped':
                $exp_date       = $this->getExpiredFromSetting('expired_shipped');
                $result         = $this->checkIsExpired($exp_date['value'], $transac_date);
                break;
            case 'delivered':
                $result         = new jsend('fail', (array)'Transaction has been completed');        
                break;
            case 'canceled':
                $result         = new jsend('fail', (array)'Transaction has been cancelled');        
                break;
            default:
                $result         = new jsend('fail', (array)'Transaction status not found');        
                break;
        }
        return($result);
    }


    public function getExpiredFromSetting($type)
    {
        $exp_date       = Policy::type($type)->ondate('now')->first();
        
        if(empty($exp_date))
        {
            throw new Exception('Setting not found.');
        }

        return $exp_date;
    }


    public function checkIsExpired($exp_date, $transac_date)
    {
        if(date('Y-m-d H:i:s') >= date('Y-m-d H:i:s', strtotime($transac_date . $exp_date)) )
        {
            $result         = new jsend('success', (array)'Expired');        
        }
        else
        {
            $result         = new jsend('success', (array)'Live');        
        }
        return $result;
    }
}
