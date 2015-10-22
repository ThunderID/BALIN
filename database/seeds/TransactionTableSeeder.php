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
		
		factory(App\Models\Transaction::class, 20)->create()->each(function($q) 
		{
			$q->save();
		});
	}
}