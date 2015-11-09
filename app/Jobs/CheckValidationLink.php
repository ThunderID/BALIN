<?php

namespace App\Jobs;

use App\Libraries\JSend;
use App\Jobs\Job;
use App\Models\User;
use App\Models\PointLog;
use App\Models\StoreSetting;
use Illuminate\Contracts\Bus\SelfHandling;
use DB, Carbon;

class CheckValidationLink extends Job implements SelfHandling
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user							= $user;
    }

    public function handle()
    {
        // checking
		if(is_null($this->user->id))
		{
		    throw new Exception('Sent variable must be object of a record.');
		}

		$result								= new JSend('success', (array)$this->user);

		//validate
		if($this->user['activation_link'] && !$this->user['is_active'])
		{
			$gift                    		= StoreSetting::type('welcome_gift')->Ondate('now')->first();

            if($gift)
            {
            	$expired_at 				= new Carbon('+ 3 months');

				DB::BeginTransaction();

				$point 						= new PointLog;

				$point->fill([
						'user_id'			=> $this->user->id,
						'amount'			=> $gift->value,
						'expired_at'		=> $expired_at->format('Y-m-d H:i:s'),
						'notes'				=> 'Welcom Gift dari BALIN',
					]);

				if(!$point->save())
				{
					DB::rollback();

				    $result					= new JSend('error', (array)$this->user, $point->getError());
				}
				else
				{
					$this->user->is_active 			= true;
					$this->user->activation_link 	= '';

					if(!$this->user->save())
					{
						DB::rollback();

					    $result				= new JSend('error', (array)$this->user, $this->user->getError());
					}
					else
					{
						DB::commit();
					}
				}
			}
			else
			{
			    $result						= new JSend('error', (array)$this->user, 'Tidak dapat klaim point.');
			}
		}
		elseif($this->user['is_active'])
		{
		    $result							= new JSend('error', (array)$this->user, 'Point sudah pernah di klaim.');
		}

		return $result;
    }
}
