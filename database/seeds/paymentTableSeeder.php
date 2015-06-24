<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory;
use Models\Payment;
use Models\Transaction;
use Illuminate\Support\Facades\DB;

class paymentTableSeeder extends Seeder
{
	function run()
	{
		DB::table('payments')->truncate();
		$faker 										= Factory::create();

		$Transactions								= Transaction::where('status' , '<', 3)->get();
		$total_transaction							= count($Transactions);

		try
		{
			for ($i = 1; $i < $total_transaction; $i++) 
			{
				$data = new payment;
				$data->fill([
					'name'							=> $faker->name,
					'bank'							=> $faker->word,
					'account_number'				=> $faker->creditCardNumber,
					'date'							=> $faker->date($format = 'Y-m-d', $max = 'now')
				]);

				$Transaction 						= $Transactions[$i];
				
				$data->transaction()->associate($Transaction->id);					

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