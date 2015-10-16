<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class TransactionDetailTableSeeder extends Seeder
{
	function run()
	{
		DB::table('transaction_details')->truncate();
		
		factory(App\Models\TransactionDetail::class, 50)->create()->each(function($q) {
			$q->save();
		});
	}
}