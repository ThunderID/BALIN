<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Product;
use Models\Inventory;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class inventoryTableSeeder extends Seeder
{
	function run()
	{
		DB::table('inventories')->truncate();
		$faker 										= Factory::create();

		$total_product								= Product::count();

		try
		{
			for ($i = 1; $i < $total_product; $i++) 
			{
				$data = new Inventory;
				$data->fill([
					'number_of_stock'				=> rand(1,100)
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