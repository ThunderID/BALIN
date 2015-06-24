<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Shipping;
use Models\Courier;
use Models\Transaction;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class shippingTableSeeder extends Seeder
{
	function run()
	{
		DB::table('shippings')->truncate();
		$faker 										= Factory::create();

		$Transactions								= Courier::where('status' , '<', 3)->get();
		$total_transaction							= count($Transactions);

		$Couriers 									= Courier::where('status' , '=', 1)->get();
		$total_courier								= count($Couriers) - 1;

		try
		{
			for ($i = 1; $i < $total_transaction; $i++) 
			{
				$data = new shipping;
				$data->fill([
					'name'							=> $faker->name,
					'code'							=> $faker->word,
					'address'						=> $faker->streetAddress,
					'zip_code'						=> $faker->postcode,
					'phone'							=> $faker->phoneNumber,
					'date'							=> $faker->dateTime($max = 'now')->format('Y-m-d')	
				]);


				$Transaction 						= $Transactions[$i];
				
				$data->transaction()->associate($Transaction->id);	


				$Courier 							= $Couriers[rand(0,$total_courier)];
				
				$data->courier()->associate($Courier->id);		


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
		}		
	}
}			