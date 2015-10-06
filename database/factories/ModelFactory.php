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
		'address' 						=> $faker->address,
	];
});

$types 									= ['sell', 'buy'];
$status 								= ['waiting','paid','shipping','delivered','canceled'];
$factory->define(App\Models\Transaction::class, function ($faker) use ($types, $status)
{
	$rand 								= rand(0, count($types)-1);
	if($types[$rand]=='buy')
	{
		return 
		[
			'supplier_id' 				=> App\Models\Supplier::all()->random()->id,
			'ref_number' 				=> bin2hex(openssl_random_pseudo_bytes(8)),
			'type' 						=> $types[$rand],
			'status' 					=> $status[rand(0, count($status)-1)],
			'transacted_at' 			=> $faker->dateTimeThisYear,
			'unique_number' 			=> str_pad(date('is'), 3, '0', STR_PAD_LEFT),
			'shipping_cost' 			=> date('h')*1000,
		];
	}
	else
	{
		return 
		[
			'user_id' 					=> App\Models\User::all()->random()->id,
			'ref_number' 				=> bin2hex(openssl_random_pseudo_bytes(8)),
			'type' 						=> $types[$rand],
			'status' 					=> $status[rand(0, count($status)-1)],
			'transacted_at' 			=> $faker->dateTimeThisYear,
			'unique_number' 			=> str_pad(date('is'), 3, '0', STR_PAD_LEFT),
			'shipping_cost' 			=> date('h')*1000,
		];
	}
});


$factory->define(App\Models\TransactionDetail::class, function ($faker)
{
	$product_id 						= App\Models\Product::all()->random()->id;

	$product 							= App\Models\Product::id($product_id)->first();
	return 
	[
		'user_id'						=> App\Models\User::all()->random()->id,
		'product_id' 					=> $product_id,
		'quantity' 						=> rand(1, 50),
		'price' 						=> ($product->dicounts[0]->promo_price!=0 ? $product->dicounts[0]->promo_price : $product->prices[0]->price),
		'discount' 						=> ($product->dicounts[0]->promo_price!=0 ? ($product->prices[0]->price - $product->dicounts[0]->promo_price) : 0),
	];
});
