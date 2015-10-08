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
		'referral_code' 				=> bin2hex(openssl_random_pseudo_bytes(4)),
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

$factory->define(App\Models\ShippingCost::class, function ($faker)
{
	return 
	[
		'courier_id'					=> App\Models\Courier::all()->random()->id,
		'start_postal_code' 			=> $faker->postcode,
		'end_postal_code' 				=> $faker->postcode,
		'cost' 							=> date('s')*1000,
	];
});

$types 									= ['sell', 'buy'];
$status 								= ['waiting','paid','shipped','delivered','canceled'];
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
			'referral_code' 			=> App\Models\User::all()->random()->referral_code,
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

	if(isset($product->dicounts[0]) && $product->dicounts[0]->promo_price!=0)
	{
		$price 							= $product->prices[0]->price;
		$discounts 						= $product->prices[0]->price - $product->discounts[0]->promo_price;
	}
	elseif(isset($product->prices[0]))
	{
		$price 							= $product->prices[0]->price;
		$discounts 						= 0;
	}
	else
	{
		$price 							= 0;
		$discounts 						= 0;
	}

	return 
	[
		'transaction_id'				=> App\Models\Transaction::all()->random()->id,
		'product_id' 					=> $product_id,
		'quantity' 						=> rand(1, 50),
		'price' 						=> $price,
		'discount' 						=> $discounts,
	];
});

$factory->define(App\Models\FeaturedProduct::class, function ($faker)
{
	return 
	[
		'product_id'					=> App\Models\Product::all()->random()->id,
		'started_at' 					=> $faker->dateTimeBetween($startDate = '- 3 months', $endDate = 'now'),
		'ended_at' 						=> $faker->dateTimeBetween($startDate = '+ 3 months', $endDate = '+ 12 months'),
	];
});