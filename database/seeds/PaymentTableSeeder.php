<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class PaymentTableSeeder extends Seeder
{
	function run()
	{
		DB::table('payments')->truncate();
		$faker 										= Factory::create();
		try
		{
			$transactions 							= App\Models\Transaction::type('sell')->status(['wait'])->take((App\Models\Transaction::type('sell')->status(['wait'])->count() * 0.8))->get();

			foreach($transactions as $key => $value)
			{
				$total 								= $value->amount;

				$data 								= new Payment;
				$data->fill([
					'transaction_id'				=> $value->id,
					'method'						=> 'bank transfer',
					'destination'					=> 'BCA',
					'account_name'					=> $faker->creditCardType,
					'account_number'				=> $faker->creditCardNumber,
					'ondate'						=> date('Y-m-d'),
					'amount'						=> $total,
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
    		echo 'Caught exception: ',  $e->getFile(), "\n";
    		echo 'Caught exception: ',  $e->getLine(), "\n";
		}		
	}
}			