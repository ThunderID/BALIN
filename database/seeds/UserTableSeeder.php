<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Address;
use Faker\Factory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        factory(App\Models\User::class, 'admin', 1)->create();
        factory(App\Models\User::class, 'staff', 1)->create();
        factory(App\Models\User::class, 'store_manager', 1)->create();

		// factory(App\Models\User::class, 20)->create()->each(function($q) 
		// {
		// 	$q->save();
		// });

		// $faker                          = Faker\Factory::create();

		// $users                          = User::all();

		// foreach ($users as $key => $value) 
		// {
		//     $address                    = new Address;

		//     $address->fill([
		//         'phone'             => $faker->phoneNumber,
		//         'zipcode'           => $faker->postcode,
		//         'address'           => $faker->address,
		//     ]);

		//     $address->owner()->associate($value);

		//     if(!$address->save())
		//     {
		//         dd($address->getError());
		//     }
		// }
    }
}
