<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Category;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class categoryTableSeeder extends Seeder
{
	function run()
	{
		DB::table('categories')->truncate();
		$faker 										= Factory::create();

		try
		{
			for ($i = 1; $i <= 5; $i++) 
			{
				$data = new category;
				$data->fill([
					'name'							=> $faker->word,
					'path'							=> $i,
					'parent_id'						=> 0			
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}					
			}

			$Categories								= Category::where('parent_id' , '=', 0)->get();
			$total_categories						= count($Categories) -1;

			for ($i = 6; $i <= 20; $i++) 
			{
				$Category  							= $Categories[rand(0,$total_categories)];

				$data = new category;
				$data->fill([
					'name'							=> $faker->word,
					'path'							=> $Category->id . "," . $i,
					'parent_id'						=> $Category->id			
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}					
			}	

			$Categories								= Category::where('parent_id' , '!=', 0)->get();
			$total_categories						= count($Categories) -1;

			for ($i = 21; $i < 50; $i++) 
			{
				$Category  							= $Categories[rand(0,$total_categories)];

				$data = new category;
				$data->fill([
					'name'							=> $faker->word,
					'path'							=> $Category->path . "," . $i,
					'parent_id'						=> $Category->id			
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