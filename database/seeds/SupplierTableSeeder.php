<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class SupplierTableSeeder extends Seeder
{
	function run()
	{
		DB::table('suppliers')->truncate();

		factory(App\Models\Supplier::class, 50)->create()->each(function($q) {
			$q->save();
		});
	}
}			