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
        
        $this->call('StoreSettingTableSeeder');

        $this->call('CategoryTableSeeder');
        $this->call('ProductTableSeeder');
        $this->call('LableTableSeeder');

        $this->call('UserTableSeeder');
        $this->call('SupplierTableSeeder');
        
        $this->call('CourierTableSeeder');
        $this->call('ShippingCostTableSeeder');
        $this->call('VoucherTableSeeder');
        $this->call('PointLogTableSeeder');

        $this->call('TransactionTableSeeder');
        $this->call('TransactionDetailTableSeeder');
        $this->call('TransactionLogTableSeeder');

        $this->call('PaymentTableSeeder');
        $this->call('ShipmentTableSeeder');

        Model::reguard();
    }
}
