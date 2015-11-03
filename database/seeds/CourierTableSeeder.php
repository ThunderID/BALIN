<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Courier;
use App\Models\Address;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class CourierTableSeeder extends Seeder
{
	function run()
	{
		DB::table('couriers')->truncate();

		$faker = Faker\Factory::create();

		for ($i=0; $i < 100 ; $i++) { 
			$data 					= new Courier;

			$data->fill([
				'name'				=> $faker->name,
			]);

			$data->save();

			$address				= new Address;			

			$address->fill([
				'phone' 			=> $faker->phoneNumber,
				'zipcode' 			=> $faker->postcode,
				'address' 			=> $faker->address,
			]);

			$address->owner()->associate($data);

			$address->save();
		}
	}
}