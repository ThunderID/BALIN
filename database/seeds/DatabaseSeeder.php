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

        $this->call('customerTableSeeder');
        $this->call('creditLogTableSeeder');
        $this->call('courierTableSeeder');
        $this->call('settingTableSeeder');
        $this->call('shippingTableSeeder');
        $this->call('paymentTableSeeder');
        $this->call('transactionTableSeeder');

        // Model::reguard();
    }
}
