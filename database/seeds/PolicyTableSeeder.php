<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Policy;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class PolicyTableSeeder extends Seeder
{
	function run()
	{
		DB::table('tmp_policies')->truncate();

		$types 										= ['expired_draft', 'expired_holded', 'expired_paid', 'expired_shipped', 'reset_point', 'referral_royalty', 'referral_discount', 'limit_unique_number', 'min_transfer', 'multiple_point'];
		$values 									= [' + 1 day', '+ 2 days', ' + 2 day', '+ 5 days', '+ 1 year', '10', '5', '100', '10000', '1000'];
		try
		{
			$i 										= 0;
			foreach($types as $key => $value)
			{
				$data 								= new Policy;
				$data->fill([
					'type'							=> $value,
					'value'							=> $values[$key],
					'started_at'					=> date('Y-m-d H:i:s'),
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}
			}	
		}
		catch (Exception $e) 
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
    		echo 'Caught exception: ',  $e->getFile(), "\n";
    		echo 'Caught exception: ',  $e->getLine(), "\n";
		}		
	}
}			