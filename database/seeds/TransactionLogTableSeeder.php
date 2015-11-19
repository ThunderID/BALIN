<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class TransactionLogTableSeeder extends Seeder
{
	function run()
	{
		// DB::table('transaction_logs')->truncate();
		$faker 										= Factory::create();
		$transactions 								= Transaction::type('sell')->status('cart')->get();

		$status 									= ['wait', 'canceled'];

		try
		{
			foreach($transactions as $value)
			{
				$next 								= rand(0,1);

				foreach (range(0, $next) as $key2) 
				{
					$data 							= new TransactionLog;
					$data->fill([
						'transaction_id'			=> $value->id,
						'status'					=> $status[$key2],
						'changed_at'				=> date('Y-m-d H:i:s', strtotime($value->transact_at->format('y-m-d H:i:s').' + '.($key2+3).' hours')),
					]);

					if (!$data->save())
					{
						print_r($data->getError());
						exit;
					}
				}
			}
		}
		catch (Exception $e) 
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
    		echo 'Caught exception: ',  $e->getLine(), "\n";
    		echo 'Caught exception: ',  $e->getFile(), "\n";
		}		
	}
}			