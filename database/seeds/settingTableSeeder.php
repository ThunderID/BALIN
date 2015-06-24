<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Setting;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class settingTableSeeder extends Seeder
{
	function run()
	{
		DB::table('settings')->truncate();
		$faker 										= Factory::create();
		try
		{
			foreach(range(1, 25) as $index)
			{
				$data = new setting;
				$data->fill([
					'setting'						=> $faker->word,
					'value'							=> $faker->word				
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