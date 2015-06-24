<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Product;
use Models\Image;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class imageTableSeeder extends Seeder
{
	function run()
	{
		DB::table('images')->truncate();
		$faker 										= Factory::create();

		$total_product								= Product::count();

		try
		{
			for ($i = 1; $i < $total_product; $i++) 
			{
				$data = new Image;
				$data->fill([
					'path'				=> $faker->word
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