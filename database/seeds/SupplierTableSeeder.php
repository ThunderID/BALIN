<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\Address;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class SupplierTableSeeder extends Seeder
{
	function run()
	{
		DB::table('suppliers')->truncate();

		$faker = Faker\Factory::create();

		// factory(App\Models\Supplier::class, 10)->create()->each(function($q) {
		// 	$q->save();
		// });

		for ($i=0; $i < 100 ; $i++) 
		{ 
			$data 					= new Supplier;

			$data->fill([
				'name'				=> $faker->company,
			]);

			if (!$data->save())
			{
				print_r($data->getError());
				exit;
			}

			$address				= new Address;			

			$address->fill([
				'phone' 			=> $faker->phoneNumber,
				'zipcode' 			=> $faker->postcode,
				'address' 			=> $faker->address,
			]);

			$address->owner()->associate($data);

			if (!$address->save())
			{
				print_r($address->getError());
				exit;
			}
		}		
	}
}			