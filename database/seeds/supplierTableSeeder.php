<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\supplier;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class supplierTableSeeder extends Seeder
{
	function run()
	{
		DB::table('suppliers')->truncate();
		$faker 									= Factory::create();
		try
		{
			foreach(range(1, 50) as $index)
			{
				$data = new supplier;
				$data->fill([
					'name'						=> $faker->name,
					'phone'						=> $faker->phoneNumber,
					'address'					=> $faker->address,
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
		}		
	}
}			