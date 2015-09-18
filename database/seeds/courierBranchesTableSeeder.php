<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\courierBranches;
use Models\Courier;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class courierBranchesTableSeeder extends Seeder
{
	function run()
	{
		DB::table('courier_branches')->truncate();
		$faker 										= Factory::create();

		$Couriers									= Courier::all();
		$total_courier								= count($Couriers) - 1;
		try
		{
			foreach(range(1, 25) as $index)
			{
				$data = new courierBranches;
				$data->fill([
					'name'							=> $faker->name,
					'status'						=> rand( 0 , 1 ),					
					'phone'							=> $faker->phonenumber,					
					'address'						=> $faker->address					
				]);


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