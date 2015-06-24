<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Product;
use Models\Transaction;
use Models\Transaction_detail;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class transactionDetailTableSeeder extends Seeder
{
	function run()
	{
		DB::table('transaction_details')->truncate();
		$faker 										= Factory::create();

		$total_product								= Product::count();

		$total_transaction							= Transaction::count() -1;

		try
		{
			for ($i = 1; $i < $total_transaction; $i++) 
			{
				$data = new transaction_detail;
				$data->fill([
					'qty'							=> rand(0,100),
					'price'							=> rand(10000,100000),
				]);

				$Transaction 						= Transaction::find($i);

				$data->transaction()->associate($Transaction->id);				


				$Product 							= Product::find(rand(0,$total_product));
				
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