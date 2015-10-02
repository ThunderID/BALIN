<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('categoryTableSeeder');
        $this->call('productTableSeeder');
        $this->call('category_productTableSeeder');
        $this->call('attributeTableSeeder');


        // Model::reguard();
    }
}
