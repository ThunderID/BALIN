<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\PointLog;
use App\Models\StoreSetting;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;


class SendReminderEmail extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

	public function __construct()
	{
		//
	}

	public function handle()
	{
		$store 			= StoreSetting::type('expired_point_warn')->ondate('now')->first();

		if($store)
		{
			$points 	= PointLog::where('expired_at', '<', date('Y-m-d H:i:s', strtotime($store->value)))->selectraw('point_logs.*')->selectraw('IFNULL(sum(amount),0) as amount')->groupby('user_id')->with(['user'])->get();

	        $info           = StoreSetting::storeinfo(true)->get();
	        $infos          = [];

	        foreach ($info as $key => $value) 
	        {
	            $infos[$value->type]    = $value->value;
	        }

			foreach ($points as $key => $value) 
			{
		        $datas          = ['points' => $value, 'balin' => $infos, 'expired' => date('d-m-Y H:i', strtotime($store->value))];

		        $mail_data      = [
		                            'view'          => 'emails.points.reminder', 
		                            'datas'         => $datas,
		                            'dest_email'    => $value['user']['email'], 
		                            'dest_name'     => $value['user']['name'], 
		                            'subject'       => 'BALIN - Reminder', 
		                        ];

		        // call email send job
		        $this->dispatch(new Mailman($mail_data));
			}
		}
	        
	    return new JSend('success', []) ;
	}	
}
