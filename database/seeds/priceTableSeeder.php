<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\product;
use Models\price;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class priceTableSeeder extends Seeder
{
	function run()
	{
		DB::table('prices')->truncate();
		$faker 										= Factory::create();
		try
		{
			$product_length							= product::count();

			foreach(range(1, 100) as $index)
			{
				$data = new price;
				$data->fill([
					'price'						=> rand(100000,500000),
					'start_date'				=> $faker->dateTime($max = 'now')->format('Y-m-d'),
				]);

				$data->product()->associate(rand(1, $product_length	));

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