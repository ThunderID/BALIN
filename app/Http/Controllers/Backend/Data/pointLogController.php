<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\baseController;
// use App\Http\Controllers\Controller;


use App\Models\User;
use App\Models\pointlog;
use App\Models\transaction;

use App\Jobs\PointIsAvailable;

use Input, DB;

class pointLogController extends baseController 
{
	protected $controller_name 				= 'Points';
	protected $inputs						= ['id','user_id','transaction_id','debit','credit','notes'];

	public function index()
	{		

	}

	public function debit()
	{		
		$this->inputs['id']					= Input::get('id');
		$this->inputs['user_id']			= Input::get('user_id');
		$this->inputs['transaction_id']		= Input::get('transaction_id');
		$this->inputs['debit']				= Input::get('debit');
		$this->inputs['credit']				= null;
		$this->inputs['notes']				= Input::get('notes');

		$this->store();
	}

	public function credit()
	{
		$this->inputs['id']					= Input::get('id');
		$this->inputs['user_id']			= Input::get('user_id');
		$this->inputs['transaction_id']		= Input::get('transaction_id');
		$this->inputs['debit']				= Input::get('debit');
		$this->inputs['notes']				= Input::get('notes');

		// $this->inputs['credit']				= null;
		// $this->inputs['id']					= null;
		// $this->inputs['user_id']			= 1;
		// $this->inputs['transaction_id']		= null;
		// $this->inputs['debit']				= 0;
		// $this->inputs['credit']				= 1;	
		// $this->inputs['notes']				= 'asdag';

 
		$this->store();
	}

	public function Store()
	{
		if($this->inputs['id'])
		{
			$data							= pointlog::find($this->inputs['id']);
		}
		else
		{
			$data 							= new pointlog;
		}


		$user 								= user::find($this->inputs['user_id']);

		if(empty($user))
		{
			//return error
			dd('user not found');
		}

		//cek point
		if($this->inputs['credit'] > 0)
		{
			$result 						= $this->dispatch(new PointIsAvailable($user, $this->inputs['credit'] ));
			if($result->getStatus() != 'success')
			{
				dd($result);
			}
		}


		$data->fill([
			'debit'							=> $this->inputs['debit'],	
			'credit'						=> $this->inputs['credit'],	
			'notes'							=> $this->inputs['notes'],	
		]);

		$data->user()->associate($user);

		$transaction 						= transaction::find($this->inputs['transaction_id']);
		if(!empty($transaction))
		{
			$data->transaction()->associate($transaction);
		}


		DB::beginTransaction();
		if (!$data->save())
		{
			DB::rollback();
			// return Redirect::back()
			// 	->withInput()
			// 	->withErrors($data->getError())
			// 	->with('msg-type', 'danger');
			dd('error');
		}	
		else
		{
			DB::commit();
			// return Redirect::route('backend.price.index')
			// 	->with('msg','Data sudah ditambahkan')
			// 	->with('msg-type', 'success');
			dd('saved');
		}

	}		
}