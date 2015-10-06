<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
$gender 								= ['male', 'female'];
$role 									= ['customer', 'cashier', 'admin'];

$factory->define(App\Models\User::class, function ($faker) use ($gender, $role)
{
	return 
	[
		'name'							=> $faker->name,
		'email'							=> $faker->email,
		'password' 						=> bcrypt('admin'),
		'role' 							=> $role[rand(0,2)],
		'gender' 						=> $gender[rand(0,1)],
		'refferal_code' 				=> bin2hex(openssl_random_pseudo_bytes(4)),
		'remember_token' 				=> str_random(10),
	];
});

$gender 								= ['male', 'female'];
$role 									= ['customer', 'cashier', 'admin'];
