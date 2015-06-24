<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory;
use Models\Transaction;
use Models\Customer;
use Illuminate\Support\Facades\DB;

class transactionTableSeeder extends Seeder
{
	function run()
	{
		DB::table('transactions')->truncate();
		$faker 										= Factory::create();

		$status 									= ['male', 'female'];
		$total_cust									= Customer::count();

		try
		{
			foreach(range(1, 50) as $index)
			{
				$data = new transaction;
				$data->fill([
					'date'							=> $faker->dateTime($max = 'now')->format('Y-m-d'),	
					'unique_number' 				=> rand(0,1000),
					'total_product_price' 			=> rand(1000000, 10000000000),
					'shipping_cost' 				=> rand(10000, 100000),
					'total_price' 					=> rand(100000, 1000000),
					'status'						=> rand(0,4),
				]);

				$customer 							= Customer::find(rand(1,$total_cust));
				
				$data->customer()->associate($customer->id);

				if(rand(0,1) == 1)
				{
					$data->fill([
						'coupon_code'					=> $customer->coupon_code	
					]);
				}	

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