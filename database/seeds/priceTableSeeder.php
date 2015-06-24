<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Product;
use Models\Price;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class priceTableSeeder extends Seeder
{
	function run()
	{
		DB::table('prices')->truncate();
		$faker 										= Factory::create();

		$total_product								= Product::count();

		try
		{
			for ($i = 1; $i < $total_product; $i++) 
			{
				$data = new Price;
				$data->fill([
					'price'							=> $faker->randomNumber(5),
					'promo_price'					=> $faker->randomNumber(5),
					'start_date'					=> $faker->dateTime($max = 'now')->format('Y-m-d'),
					'end_date'						=> $faker->dateTime($max = 'now')->format('Y-m-d')
				]);

				$Product 							= Product::find($i);
				
				$data->product()->associate($Product->id);				

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