<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory;
use Models\Payment;
use Illuminate\Support\Facades\DB;

class paymentTableSeeder extends Seeder
{
	function run()
	{
		DB::table('payments')->truncate();
		$faker 										= Factory::create();

		try
		{
			foreach(range(1, 50) as $index)
			{
				$data = new payment;
				$data->fill([
					'name'							=> $faker->name,
					'bank'							=> $faker->word,
					'account_number'				=> $faker->creditCardNumber,
					'date'							=> $faker->date($format = 'Y-m-d', $max = 'now')
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