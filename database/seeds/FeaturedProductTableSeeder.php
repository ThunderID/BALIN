<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\FeaturedProduct;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class FeaturedProductTableSeeder extends Seeder
{
	function run()
	{
		DB::table('tmp_featured_products')->truncate();

		factory(App\Models\FeaturedProduct::class, 100)->create()->each(function($q) {
			$q->save();
		});
	}
}