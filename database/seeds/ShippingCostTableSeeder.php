<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingCost;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class ShippingCostTableSeeder extends Seeder
{
	function run()
	{
		DB::table('shipping_costs')->truncate();

		factory(App\Models\ShippingCost::class, 20)->create()->each(function($q) {
			$q->save();
		});
	}
}