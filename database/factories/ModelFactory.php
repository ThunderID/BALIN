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
$role 									= ['customer', 'staff', 'store_manager', 'admin', 'developer'];

$factory->define(App\Models\User::class, function ($faker) use ($gender, $role)
{
	if(!App\Models\User::count()==0)
	{
		// return 
		// [
		// 	'name'						=> 'BALIN',
		// 	'email'						=> 'cs@balin.id',
		// 	'password' 					=> bcrypt('admin'),
		// 	'role' 						=> 'admin',
		// 	'gender' 					=> 'male',
		// 	'remember_token' 			=> str_random(10),
		// ];		
	}
	return 
	[
		'name'							=> $faker->name,
		'email'							=> $faker->email,
		'password' 						=> bcrypt('admin'),
		'role' 							=> $role[rand(0,4)],
		'gender' 						=> $gender[rand(0,1)],
		'remember_token' 				=> str_random(10),
	];
});

$factory->define(App\Models\Voucher::class, function ($faker)
{
	$types 								= ['free_shipping_cost', 'debit_point'];

	$values 							= [0, (date('s')*1000)];

	$type 								= rand(0, 1);

	return 
	[
		'code' 							=> bin2hex(openssl_random_pseudo_bytes(4)),
		'type' 							=> $types[$type],
		'value' 						=> $values[$type],
        'started_at'                    => $faker->dateTimeBetween($startDate = 'now', $endDate = '+ 3 months'),
		'expired_at' 					=> $faker->dateTimeBetween($startDate = '+ 3 months', $endDate = '+ 12 months'),
	];
});

$factory->define(App\Models\PointLog::class, function ($faker)
{
	return 
	[
		'user_id'					=> App\Models\User::all()->random()->id,
		'reference_id'				=> App\Models\User::all()->random()->id,
		'reference_type'			=> 'App\Models\User',
		'expired_at'				=> $faker->dateTimeBetween($startDate = '+ 3 months', $endDate = '+ 12 months'),
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
$status 								= ['draft','waiting','paid','shipped','delivered','canceled'];
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
			'transact_at' 				=> $faker->dateTimeThisYear,
			'unique_number' 			=> str_pad(date('is'), 3, '0', STR_PAD_LEFT),
			'shipping_cost' 			=> date('h')*1000,
		];
	}
	else
	{
		return 
		[
			'user_id' 					=> App\Models\User::all()->random()->id,
			// 'voucher_id' 				=> App\Models\Voucher::all()->random()->id,
			'ref_number' 				=> bin2hex(openssl_random_pseudo_bytes(8)),
			'type' 						=> $types[$rand],
			'transact_at' 				=> $faker->dateTimeThisYear,
			'unique_number' 			=> str_pad(date('is'), 3, '0', STR_PAD_LEFT),
			'shipping_cost' 			=> date('h')*1000,
		];
	}
});


$factory->define(App\Models\TransactionDetail::class, function ($faker)
{
	$varian 							= App\Models\Varian::all()->random();
	$varian_id 							= $varian->id;

	$product 							= App\Models\Product::id($varian->product_id)->first();

	$transaction 						= App\Models\Transaction::all()->random();

	if($transaction->status=='sell')
	{
		$price 							= $product->price;
		$discount 						= $product->discount;
	}
	else
	{
		$price 							= $product->price - ($product->price * 0.1);
		$discount 						= 0;
	}

	return 
	[
		'transaction_id'				=> $transaction->id,
		'varian_id' 					=> $varian_id,
		'quantity' 						=> rand(1, 50),
		'price' 						=> $product->price,
		'discount' 						=> $product->discount,
	];
});
