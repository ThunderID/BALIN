<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class TransactionTableSeeder extends Seeder
{
	function run()
	{
		DB::table('transactions')->truncate();
		DB::table('transaction_logs')->truncate();
		
		factory(App\Models\Transaction::class, 5000)->create()->each(function($q) 
		{
			$q->save();
		});
	}
}