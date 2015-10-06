<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Courier;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class CourierTableSeeder extends Seeder
{
	function run()
	{
		DB::table('couriers')->truncate();

		factory(App\Models\Courier::class, 10)->create()->each(function($q) {
			$q->save();
		});
	}
}