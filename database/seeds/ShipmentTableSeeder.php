<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shipment;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class ShipmentTableSeeder extends Seeder
{
	function run()
	{
		DB::table('shipments')->truncate();
		$faker 										= Factory::create();
		try
		{
			$transactions 							= App\Models\Transaction::type('sell')->status(['paid'])->take((App\Models\Transaction::type('sell')->status(['paid'])->count() * 0.7));
			
			foreach($transactions as $key => $value)
			{
				$data 								= new Shipment;
				$data->fill([
					'courier_id'					=> App\Models\Courier::all()->random()->id,
					'transaction_id'				=> $value->id,
					'receipt_number'				=> bin2hex(openssl_random_pseudo_bytes(5)),
					'name'							=> $faker->firstName,
					'ondate'						=> date('Y-m-d'),
					'phone'							=> $faker->phoneNumber,
					'address'						=> $faker->address,
					'postal_code'					=> $faker->postcode,
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}

				$check 								= rand(0,1);
				if($check)
				{
					$trs 								= App\Models\Transaction::find($value->id);
					$trs->fill(['status' => 'delivered']);

					if (!$trs->save())
					{
						print_r($trs->getError());
						exit;
					}
				}
			}	
		}
		catch (Exception $e) 
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
    		echo 'Caught exception: ',  $e->getFile(), "\n";
    		echo 'Caught exception: ',  $e->getLine(), "\n";
		}		
	}
}			