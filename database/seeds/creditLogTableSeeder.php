<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Credit_log;
use Models\Customer;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class creditLogTableSeeder extends Seeder
{
	function run()
	{
		DB::table('credit_logs')->truncate();
		$faker 										= Factory::create();
		$total_cust									= Customer::count();

		try
		{
			foreach(range(1, 50) as $index)
			{
				$data = new credit_log;
				if(rand ( 0 , 1 ) == 1)
				{
					$data->fill([
						'name'							=> $faker->word,
						'debet'							=> 0,
						'credit'						=> $faker->numberBetween($min = 1000, $max = 9000),
						'date'							=> date("y-m-d", strtotime('now')),
						'expired_date'					=> date("y-m-d", strtotime('+ 1 year')) ,
					]);
				}else{
					$data->fill([
						'name'							=> $faker->word,
						'debet'							=> $faker->numberBetween($min = 1000, $max = 9000),
						'credit'						=> 0,
						'date'							=> date("y-m-d", strtotime('now')),
						'expired_date'					=> date("y-m-d", strtotime('+ 1 year')) ,
					]);
				}

				$customer 							= Customer::find(rand(1,$total_cust));
				
				$data->customer()->associate($customer->coupon_code);

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