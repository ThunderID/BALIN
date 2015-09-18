<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Customer;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class customerTableSeeder extends Seeder
{
	function run()
	{
		DB::table('customers')->truncate();
		$faker 										= Factory::create();
		$gender 									= ['male', 'female'];
		try
		{
			foreach(range(1, 50) as $index)
			{
				$data = new customer;
				$data->fill([
					'name'							=> $faker->name,
					'username'						=> $faker->username,
					'email'							=> $faker->email,
					'dob'							=> $faker->dateTime($max = 'now')->format('Y-m-d'),
					'address'						=> $faker->streetAddress,
					'zip_code'						=> $faker->postcode,
					'phone'							=> $faker->phoneNumber,
					'gender'						=> $gender[rand ( 0 , 1 )],
					'coupon_code'					=> $faker->unixTime($max = 'now'),
					'coupon_balance'				=> 0,
					'profile_photo'					=> $faker->sentence($nbWords = 6),
					'join_date'						=> $faker->dateTime($max = 'now')->format('Y-m-d'),
					'sso_data'						=> $faker->sentence($nbWords = 6),
					'sso_type'						=> $faker->sentence($nbWords = 1),
					'sso_id'						=> $faker->sentence($nbWords = 1),
					'password'						=> Hash::make('admin'),
					'remember_token'				=> $faker->sentence($nbWords = 6),
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}
			}

		}
		catch (Exception $e) 
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
		}		
	}
}