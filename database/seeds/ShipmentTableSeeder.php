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
			$transactions 							= App\Models\Transaction::type('sell')->status(['shipping','delivered'])->get();
			
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
					'status'						=> $value->status,
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
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