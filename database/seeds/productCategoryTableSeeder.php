<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Product;
use Models\Product_category;
use Models\Category;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class productCategoryTableSeeder extends Seeder
{
	function run()
	{
		DB::table('product_categories')->truncate();
		$faker 										= Factory::create();

		$total_product								= Product::count();

		$Categories 								= Category::where('parent_id','!=','0')->get();
		$total_cat									= count($Categories) -1;

		try
		{
			for ($i = 1; $i < $total_product; $i++) 
			{
				$data = new Product_category;

				$Product 							= Product::find($i);
				
				$data->Product()->associate($Product->id);

				$Category 							= $Categories[rand(0,$total_cat)];

				$data->Category()->associate($Category->id);

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