<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\product;
use Models\discount;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class discountTableSeeder extends Seeder
{
	function run()
	{
		DB::table('discounts')->truncate();
		$faker 										= Factory::create();
		try
		{
			$product_length							= product::count();

			foreach(range(1, 75) as $index)
			{
				$data = new discount;
				$data->fill([
					'promo_price'				=> rand(100000,500000),
					'start_date'				=> $faker->dateTime($max = 'now')->format('Y-m-d'),
					'end_date'					=> $faker->dateTime($max = 'now')->format('Y-m-d'),
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