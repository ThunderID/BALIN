<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Shipping;
use Models\courierBranches;
use Models\Transaction;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class shippingTableSeeder extends Seeder
{
	function run()
	{
		DB::table('shippings')->truncate();
		$faker 										= Factory::create();

		$Transactions								= Transaction::where('status' , '<', 3)->get();
		$total_transaction							= count($Transactions);

		$Courier_branches							= courierBranches::all();
		$total_courier								= count($Courier_branches) - 1;

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


				$Courier_branch 					= $Courier_branches[rand(0,$total_courier)];

				$data->courierBranch()->associate($Courier_branch->id);		


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