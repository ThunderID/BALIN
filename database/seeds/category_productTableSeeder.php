<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\category;
use Models\product;
use Models\category_product;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class category_productTableSeeder extends Seeder
{
	function run()
	{
		DB::table('categories_products')->truncate();
		$faker 										= Factory::create();
		try
		{
			$category_length						= category::count();
			$product_length							= product::count();

			foreach(range(1, 20) as $index)
			{
				$data 								= new category_product;

				$data->category()->associate(category::find(rand(1,$category_length)));
				$data->Product()->associate(product::find(rand(1,$product_length)));

				if(!$data->save())
				{
					print_r($data->getError());
				}
			}

		}
		catch (Exception $e)  
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
    		echo 'Caught exception: ',  $e->getFile(), "\n";
    		echo 'Caught exception: ',  $e->getLine(), "\n";
		}		
	}
}				