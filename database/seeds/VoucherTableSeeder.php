<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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

		$users                         = User::all();
        foreach ($users as $key => $value) 
        {
            $voucher                      = new Voucher;
            $voucher->fill([
                    'user_id'           => $value->id,
                    'code'              => bin2hex(openssl_random_pseudo_bytes(4)),
                    'type'              => 'referral',
            ]);

            if (!$voucher->save())
            {
                print_r($voucher->getError());
                exit;
            }
        }

    }
}
