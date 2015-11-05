<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductUniversal;

use Faker\Factory;

class ProductUniversalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_universals')->truncate();

        $faker                          = Faker\Factory::create();

        for ($i=0; $i < 100; $i++)
        {
            $data                    = new ProductUniversal;

            $data->fill([
                'name'                  => $faker->name,
                'upc'                   => $faker->ean8,
                'description'           => $faker->sentence($nbWords = 6),
            ]);

            if(!$data->save())
            {
                dd($data->getError());
            }
        }

    }
}
