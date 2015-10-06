<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\discount;
use Models\product;
use Input, Session, DB, Redirect, Response;

class discountController extends baseController 
{
	protected $view_name 						= 'Discount';

	public function index()
	{		
		$datas									= discount::paginate();
		$breadcrumb								= ['Diskon' => 'backend.discount.index'];

		if (Input::get('q'))
		{
			$datas 								= product::FindProduct(Input::get('q'))
													->where('deleted_at',null)
													->with(['discount'=> function($q){$q->LatestDiscount();}])
													->paginate(); 
			$searchResult						= Input::get('q');
		}
		else
		{
			$datas								= product::with(['discount'=> function($q){$q->LatestDiscount();}])
													->paginate(); 
			$searchResult						= NULL;
		}

		$this->layout->page 					= view('pages.backend.discount.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult);
		return $this->layout;		
	}

	public function show($id)
	{
		
	}


	public function create($id = null)
	{
		if ($id)
		{
			$breadcrumb							= [ 'Diskon' => 'backend.discount.index',
													'Diskon Baru' => 'backend.discount.create' ];
			$data								= NULL;
		}
		else
		{
			$breadcrumb							= [ 'Diskon' => 'backend.discount.index',
													'Diskon Baru' => 'backend.discount.create' ];
			$data								= NULL;	
		}

		$this->layout->page 					= view('pages.backend.discount.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Create')		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('data', $data);

		return $this->layout;	
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('product','promo_price', 'start_date', 'end_date');
	
		$data 									= new discount;

		$data->fill([
			'promo_price' 						=> $inputs['promo_price'],
			'start_date' 						=> $inputs['start_date'],
			'end_date' 							=> $inputs['end_date'],
		]);

		$data->product()->associate($inputs['product']);

		DB::beginTransaction();
		if (!$data->save())
		{
			DB::rollback();
			return Redirect::back()
				->withInput()
				->withErrors($data->getError())
				->with('msg-type', 'danger');
		}	
		else
		{
			DB::commit();

			return Redirect::route('backend.discount.index')
				->with('msg','Data sudah ditambahkan')
				->with('msg-type', 'success');
		}
	}

	public function destroy($id)
	{
		
	}
}