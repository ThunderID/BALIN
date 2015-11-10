<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Courier;
use App\Models\Address;
use App\Models\ShippingCost;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class CourierTableSeeder extends Seeder
{
	function run()
	{
		DB::table('couriers')->truncate();

		$faker = Faker\Factory::create();

		for ($i=0; $i < 100 ; $i++) 
		{ 
			$data 					= new Courier;

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

			$shipcost				= new ShippingCost;			

			$shipcost->fill([
				'courier_id'		=> $data->id,
				'start_postal_code'	=> 0,
				'end_postal_code'	=> 100000,
				'started_at'		=> date('Y-m-d H:i:s', strtotime('- 1 day')),
				'cost'				=> date('s')*1000,
			]);

			if (!$shipcost->save())
			{
				print_r($shipcost->getError());
				exit;
			}
		}
	}
}