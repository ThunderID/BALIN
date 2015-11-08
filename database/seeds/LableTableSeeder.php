<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Lable;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class LableTableSeeder extends Seeder
{
	function run()
	{
		try
		{
			DB::table('couriers')->truncate();

			$faker = Faker\Factory::create();

			$products 				= Product::all();
			$lables 				= ['new_item', 'best_seller', 'sale', 'hot_item'];

			foreach ($products as $product) 
			{
				$size 				= rand(0, 3);

				for ($i=0; $i <= $size; $i++) 
				{ 
			 		$lable 			= new Lable;

			 		$lable->fill([
			 			'product_id'	=> $product['id'],
			 			'lable'			=> $lables[$i],
			 			'value'			=> 'value',
			 			'started_at'	=> date('Y-m-d H:i:s', strtotime('now'))
		 			]);
					
					$lable->save();
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