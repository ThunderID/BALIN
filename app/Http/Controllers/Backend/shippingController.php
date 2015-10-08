<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
// use Models\Shipping;
use App\Models\user;
// use Models\transaction;
// use Models\courierBranch;
use Input, Session, DB, Redirect, Mail;

class shippingController extends Controller 
{
	protected $view_name 						= 'Pengiriman';

	public function index()
	{	
		$breadcrumb								= array(
													'Pengriman Barang' => 'backend.shipping.index',
													);

		if(Input::get('q'))
		{
			$datas								= Shipping::where('name','like', '%'.Input::get('q').'%')
													->paginate();
			$searchResult						= "Menampilkan data pencarian '" .Input::get('q')."'";
		}
		else
		{
			$datas								= Shipping::with('courierBranch')
													->with('transaction')
													->with('courierBranch')
													->paginate()
													;

			$searchResult						= NUll;

		}


		$this->layout->page 					= view('pages.backend.menu-shipping.shipping.index')
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
			$data							= Shipping::find(Input::get('id'));

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
				return Redirect::route('backend.shipping.index')
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

	public function save()
	{
		// $inputs									= Input::all();
		$inputs									= Input::only('id','nota_transaksi', 'courier', 'resi', 'cost', 'date', 'name', 'phone', 'address', 'zip');
		

		if(Input::get('id'))
		{
			$data 	 							= shipping::find(Input::get('id'));
			$msg 								= "Data kantor pengirimann berhasil diubah";
		}
		else
		{
			$data 	 							= new shipping;
			$msg 								= "Data pengiriman berhasil ditambahkan";
		}
		
			// $data->courier()->associate($inputs['courier_id']);	
			// $data->courier()->associate($inputs['courier_id']);	

		// $data->fill([
		// 	'name' 								=> $inputs['name'],
		// 	'code' 								=> $inputs['resi'],
		// 	'address' 							=> $inputs['address'],
		// 	'zip_code' 							=> $inputs['zip'],
		// 	'phone' 							=> $inputs['phone'],
		// 	'date' 								=> $inputs['date']
		// ]);

		// if($data->save())
		// {
		// 	print('oke');exit;
		// }
		// else
		// {
		// 	print_r($data->getError());exit;
		// }

		print_r(Input::all());exit;
	}

}