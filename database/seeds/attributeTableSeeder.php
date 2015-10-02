<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Product;
use Models\attribute;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class attributeTableSeeder extends Seeder
{
	function run()
	{
		DB::table('attributes')->truncate();
		$faker 										= Factory::create();
		try
		{
			$product_length							= product::count();

			foreach(range(1, 50) as $index)
			{
				$data = new attribute;
				$data->fill([
					'attribute'						=> $faker->word,
					'value'							=> $faker->word,
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