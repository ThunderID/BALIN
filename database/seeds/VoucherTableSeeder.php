<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Voucher;

class VoucherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tmp_vouchers')->truncate();

        factory(App\Models\Voucher::class, 100)->create()->each(function($q) 
        {
            $q->save();
        });
    }
}
