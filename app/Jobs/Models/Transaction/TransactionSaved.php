<?php

namespace App\Jobs\Models\Transaction;

use App\Jobs\Job;
use App\Jobs\SendBillingEmail;
use App\Jobs\StockRecalculate;
use App\Jobs\GenerateRefferalCode;
use App\Jobs\SendReferralCodeEmail;
use App\Jobs\RevertUserPoints;
use App\Libraries\JSend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Models\Transaction;


class TransactionSaved extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction                  = $transaction;
    }

    public function handle()
    {
        switch($this->transaction->status)
        {
            case 'waiting' :
                $result                     = $this->dispatch(new StockRecalculate($this->transaction));
                if($result->getStatus()=='success' && !is_null($this->transaction->user) )
                {
                    $result                 = $this->dispatch(new SendBillingEmail($this->transaction));
                }
            break;
            case 'paid' :
                $result                     = $this->dispatch(new StockRecalculate($this->transaction));
                
                if($result->getStatus()=='success' && !is_null($this->transaction->user) && is_null($this->transaction->user->voucher))
                {
                    $result                 = $this->dispatch(new GenerateRefferalCode($this->transaction->user));
                    
                    if($result->getStatus()=='success')
                    {
                        $result             = $this->dispatch(new SendReferralCodeEmail($this->transaction->user, $result->getData()));
                    }
                }
            case 'shipped' :
            case 'canceled' :
                $result                     = $this->dispatch(new StockRecalculate($this->transaction));
                 if($result->getStatus()=='success' && $this->transaction->pointlogs->count())
                {
                    $result                 = $this->dispatch(new RevertUserPoints($this->transaction));
                }
            break;
            default :
                $result                     = new JSend('success', (array)$this->transaction );
            break;
        }

        return $result;
    }
}
