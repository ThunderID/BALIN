<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PointLog;

class PointLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('point_logs')->truncate();

        factory(App\Models\PointLog::class, 5)->create()->each(function($q) 
        {
            $q->save();
        });
    }
}
