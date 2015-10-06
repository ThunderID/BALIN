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

$factory->define(App\Models\Supplier::class, function ($faker)
{
	return 
	[
		'name'							=> $faker->company.' '.$faker->companySuffix,
		'phone'							=> $faker->phoneNumber,
		'address' 						=> $faker->address,
	];
});

$colors 								= ['ffcccc', 'ccccff', 'fffdcc', 'ddffcc', 'ffccfc', '000000', 'bababa', '00ffae', 'a0000a', '00fff0'];
$factory->define(App\Models\Courier::class, function ($faker) use ($colors)
{
	return 
	[
		'name'							=> $faker->company.' '.$faker->companySuffix,
		'logo_url' 						=> 'http://placehold.it/200x200/'.$colors[rand(0, count($colors)-1)].'/000000',
	];
});


$factory->define(App\Models\CourierBranch::class, function (Faker\Generator $faker) {
    return 
    [
		'courier_id' 				=> App\Models\Courier::all()->random()->id,
		'name'						=> $faker->city,
		'address'					=> $faker->address,
    ];
});
