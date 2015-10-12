<?php

namespace App\Jobs;

use App\Libraries\JSend;
use App\Jobs\Job;
use App\Models\policy;
use App\Models\transaction;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;

class ResetCart extends Job implements SelfHandling
{
    protected $transaction;

    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // get seting
        $exp_date                       = policy::GetExpiredDraft('now')->first();

        $this->transaction              = transaction::TransactionWaiting()
                                            ->whereRaw('Date(transacted_at + INTERVAL' . $exp_date['value'] .') <= CURDATE()')
                                            ->get()
                                            ;
    }

    public function handle()
    {
        if(count($this->transaction) == 0)
        {
            return new Jsend('success', (array)'No expired cart');
        }

        foreach ($this->transaction as $data) {
            //cancel transactions
            $result        = $this->dispatch(new CancelTransaction($data));

            if($result->getstatus() != "success")
            {
                return $result;
            }
        }

        return new Jsend('success', (array)'Cart has been resetting');
    }
}
