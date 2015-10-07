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

		$types 										= ['expired_draft', 'expired_holded', 'reset_point', 'referral_royalty', 'referral_discount'];
		$values 									= [' + 1 day', '+ 7 days', '+ 1 year', '10', '5'];
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