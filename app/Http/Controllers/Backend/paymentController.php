<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\Payment;
use Input, Session, DB, Redirect;

class paymentController extends baseController 
{

	protected $view_name 					= 'Pembayaran';


	public function index()
	{
		$breadcrumb								= array(
													'Pembayaran' => 'backend.payment.index',
													 );

		// if(Input::get('q'))
		// {
		// 	$datas								= Customer::where('name','like', '%'.Input::get('q').'%')
		// 											// ->where('address','like', Input::get('q'))
		// 											->paginate();
		// 	$searchResult						= "Menampilkan data pencarian '" .Input::get('q')."'";
		// }
		// else
		// {
			$datas								= Payment::with('transaction')
													->paginate()
													;
			$searchResult						= NUll;
		// }


		$this->layout->page 					= view('pages.backend.payment.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult)
													;

		return $this->layout;
	}

	public function save()
	{
		
	}

	public function delete()
	{
	
	}
}