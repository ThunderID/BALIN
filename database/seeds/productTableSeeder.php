<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Product;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class productTableSeeder extends Seeder
{
	function run()
	{
		DB::table('products')->truncate();
		$faker 										= Factory::create();
		try
		{
			foreach(range(1, 50) as $index)
			{
				$data = new product;
				$data->fill([
					'SKU'							=> $faker->ean8,
					'name'							=> $faker->word,
					'description'					=> $faker->sentence($nbWords = 6),			
					'slug'							=> $faker->sentence($nbWords = 3),			
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