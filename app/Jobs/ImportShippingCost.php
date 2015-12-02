<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\ShippingCost;
use App\Models\Courier;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\MessageBag;

use App\Libraries\JSend;
use Carbon;

class ImportShippingCost extends Job implements SelfHandling
{
    use DispatchesJobs, ValidatesRequests;

    protected $data;

	public function __construct(Courier $courier, $data)
	{
	    $this->courier			= $courier;
	    $this->data				= $data;
	}

	public function handle()
	{
		$started_at 									= Carbon::now()->format('Y-m-d H:i:s');
		$errors 										= new MessageBag();

		foreach ($this->data as $key => $value) 
		{
			$shipping 									= new ShippingCost;

			$shipping->fill([
				'courier_id' 								=> $this->courier['id'],
				'start_postal_code' 						=> $value['start_code'],
				'end_postal_code' 							=> $value['end_code'],
				'cost' 										=> $value['cost'],
				'started_at'								=> $started_at,
			]);

			if(!$shipping->save())
			{
				$errors->add('Shipping', $shipping->getError());
			}
		}

		if($errors->count())
		{
		    return new JSend('errors', (array)$data, $errors);
		}

	    return new JSend('success', (array)$this->data);
	}	
}
