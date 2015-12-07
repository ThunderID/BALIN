<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;
use App\Models\StoreSetting;
use App\Models\PointLog;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;


class SendBillingEmail extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $transaction;

	public function __construct(Transaction $transaction)
	{
	    $this->transaction				= $transaction;
	}

	public function handle()
	{
	    // checking
	    if(is_null($this->transaction->id))
	    {
	        throw new Exception('Sent variable must be object of a record.');
	    }
	    
		$transaction 	= Transaction::id($this->transaction->id)->with(['transactiondetails', 'transactiondetails.varian', 'transactiondetails.product', 'shipment', 'shipment.address', 'user'])->first();

		$point 			= 0;
		$plogs 			= PointLog::referenceid($this->transaction->id)->referencetype('App\Models\Transaction')->get();

		foreach ($plogs as $key => $value) 
		{
			if($value->amount < 0)
			{
				$point = $point - $value->amount;
			}
		}

		$transaction['discount_point']	= $point;

        $info           = StoreSetting::storeinfo(true)->get();
        $infos          = [];

        foreach ($info as $key => $value) 
        {
            $infos[$value->type]    = $value->value;
        }

	    $expired           			= StoreSetting::type('expired_paid')->ondate('now')->first();

        $infos[$expired['type']]	= $expired['value'];

        $datas          = ['bill' => $transaction, 'balin' => $infos];

        $mail_data      = [
                            'view'          => 'emails.billing', 
                            'datas'         => $datas,
                            'dest_email'    => $transaction['user']['email'], 
                            'dest_name'     => $transaction['user']['name'], 
                            'subject'       => 'BALIN - Billing Information', 
                        ];

        // call email send job
        $this->dispatch(new Mailman($mail_data));
	        
	    return new JSend('success', (array)$this->transaction)  ;
	}	
}
