<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\Customer;
use Input, Session, DB, Redirect;

class customerController extends baseController 
{
	protected $view_name 						= 'Customer';

	public function index()
	{	
		$breadcrumb								= array(
													'Customer' => 'backend.customer.index',
													 );

		if(Input::get('q'))
		{
			$datas								= Customer::where('name','like', '%'.Input::get('q').'%')
													// ->where('address','like', Input::get('q'))
													->paginate();
			$searchResult						= "Menampilkan data pencarian '" .Input::get('q')."'";
		}
		else
		{
			$datas								= Customer::paginate();
			$searchResult						= NUll;
		}


		$this->layout->page 					= view('pages.backend.customer.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult)
													;

		return $this->layout;
	}

	public function delete()
	{
		if(Input::get('id'))
		{
			$data							= Customer::find(Input::get('id'));

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
				return Redirect::route('backend.customer.index')
					->with('msg', 'Data telah dihapus')
					->with('msg-type','success')
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

}