<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Courier;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class courierTableSeeder extends Seeder
{
	function run()
	{
		DB::table('couriers')->truncate();
		$faker 										= Factory::create();
		try
		{
			foreach(range(1, 25) as $index)
			{
				$data = new Courier;
				$data->fill([
					'name'							=> $faker->word,
					'image'							=> $faker->word,					
					'status'						=> rand( 0 , 1 )					
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