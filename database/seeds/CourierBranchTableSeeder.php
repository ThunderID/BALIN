<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourierBranch;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class CourierBranchTableSeeder extends Seeder
{
	function run()
	{
		DB::table('courier_branches')->truncate();

		factory(App\Models\CourierBranch::class, 120)->create()->each(function($q) {
			$q->save();
		});
	}
}