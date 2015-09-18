<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\transaction;
use Input, Session, DB, Redirect;

class transactionController extends baseController 
{
	protected $view_name 					= 'Transaksi';


	public function index()
	{
		$breadcrumb								= array(
													'Transaksi' => 'backend.transaction.index',
													);

		// if(Input::get('q'))
		// {
		// 	$datas								= Shipping::where('name','like', '%'.Input::get('q').'%')
		// 											->paginate();
		// 	$searchResult						= "Menampilkan data pencarian '" .Input::get('q')."'";
		// }
		// else
		// {
			// $datas								= transaction::with('courierBranch')
			// 										->with('transaction')
			// 										->with('courierBranch')
			// 										->paginate()
			// 										;

		$datas = transaction::paginate();

			$searchResult						= NUll;

		// }


		$this->layout->page 					= view('pages.backend.transaction.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult)
													;


		return $this->layout;		
	}	

	public function getTransactionByName()
	{
	    $name = Input::get('invoice_no');
	    $tmp =  transaction::select(array('id', 'invoice_no'))->where('invoice_no', 'like', "%$name%")->get();
	    return json_decode(json_encode($tmp));
	}		
}