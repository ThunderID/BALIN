<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\Courier;
use Models\courierBranches;
use Input, Session, DB, Redirect;

class courierBranchesController extends baseController 
{
	public function save()
	{
		$inputs									= Input::only('courier_id','name','status','phone','address');
		
		if(Input::get('id'))
		{
			$data 								= courierBranches::find(Input::get('id'));
			$msg 								= "Data kantor cabang berhasil diubah";
		}
		else
		{
			$data 								= new courierBranches;
			$msg 								= "Data kantor cabang berhasil ditambahkan";
			$data->courier()->associate($inputs['courier_id']);	
		}

		$data->fill([
			'name'								=> $inputs['name'],
			'status'							=> $inputs['status'],
			'phone'								=> $inputs['phone'],
			'address'							=> $inputs['address']
		]);		

		DB::beginTransaction();
		if (!$data->save())
		{
			// return redirect back with error
			DB::rollback();
			return Redirect::back()
				->withInput()
				->withErrors($data->getError())
				->with('msg-type','danger')
				;
		}else{
			DB::commit();
			return Redirect::route('backend.courier.detail', ['courier_id' =>  $inputs['courier_id']])
				->with('msg', $msg)
				->with('msg-type','success')
				;
		}
	}

	public function delete()
	{
		if(Input::get('id') && Input::get('courier_id'))
		{
			if(Input::get('pwd') == 'aaa')
			{
				$data							= courierBranches::find(Input::get('id'));
			
				DB::beginTransaction();

				if(!$data->delete())
				{
					DB::rollback();
					return Redirect::back()
						->withErrors($data->getError())
						->with('msg-type','danger')
						;
				}
				else
				{
					DB::commit();
					return Redirect::route('backend.courier.detail', ['courier_id' => Input::get('courier_id')])
						->with('msg', 'Data telah dihapus')
						->with('msg-type','success')
						;
				}
			}
			else
			{
				return Redirect::back()
				->withInput()
				->with('msg', "Hapus data gagal. Password tidak valid")
				->with('msg-type','danger')
				;
			}
		}
		else
		{
			return Redirect::back()
				->withInput()
				->with('msg', "Hapus data gagal. Tidak ada data yang dipilih")
				->with('msg-type','danger')
				;
		}
	}

	public function getCourierBranchByName()
	{
	    $name = Input::get('name');
	    $tmp =  courierBranches::select(array('id', 'name'))->where('name', 'like', "%$name%")->get();
	    return json_decode(json_encode($tmp));
	}		
}