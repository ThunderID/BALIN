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

        // $this->call('VoucherTableSeeder');
        
        $this->call('UserTableSeeder');

        // $this->call('PointLogTableSeeder');
        // $this->call('SupplierTableSeeder');
        // $this->call('CourierTableSeeder');

        // $this->call('ShippingCostTableSeeder');
        
        // $this->call('CategoryTableSeeder');
        // $this->call('ProductTableSeeder');
        // $this->call('LableTableSeeder');

        // $this->call('TransactionTableSeeder');
        // $this->call('TransactionDetailTableSeeder');

        // $this->call('ShipmentTableSeeder');
        // $this->call('TransactionLogTableSeeder');
        // $this->call('PaymentTableSeeder');
        
        Model::reguard();
    }
}
