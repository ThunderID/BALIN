<?php namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\baseController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Supplier;
use App\Models\policy;
use Input, Session, DB, Redirect, Response;

class SupplierController extends baseController 
{    
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Supplier';

	public function index()
	{	
		$breadcrumb								= ['Supplier' => 'backend.data.supplier.index'];

		if (Input::get('q'))
		{
			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= null;

		}

		$this->layout->page 					= view('pages.backend.data.supplier.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('nav_active', 'data')
													->with('subnav_active', 'supplier')
													;


		return $this->layout;	
	}

	public function show($id)
	{
		
	}


	public function create($id = null)
	{
		if (is_null($id))
		{
			$breadcrumb							= 	[	'Supplier' => 'backend.data.supplier.index',
														'Supplier Baru' => 'backend.data.supplier.create'
													];

			$title 								= 'Create';
		}
		else
		{
			$breadcrumb							= 	[	'Supplier' => 'backend.data.supplier.index',
														'Edit Data' => 'backend.data.supplier.create' 
													];

			$title 								= 	'Edit';
		}

		$this->layout->page 					= view('pages.backend.data.supplier.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle', $title)		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('id', $id)
													->with('nav_active', 'data')
													->with('subnav_active', 'supplier')
													;

		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('name', 'phone', 'address');
	
		if ($id)
		{
			$data								= Supplier::find($id);
		}
		else
		{
			$data								= new Supplier;
		}

		$data->fill([
			'name' 								=> $inputs['name'],
			'phone' 							=> $inputs['phone'],
			'address' 							=> $inputs['address'],
		]);

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

			return Redirect::route('backend.data.supplier.index')
								->with('msg', 'Supplier sudah disimpan')
								->with('msg-type', 'success');
		}
	}

	public function Update($id)
	{
		return $this->store($id);		
	}

	public function destroy($id)
	{
		$data									= Supplier::findorfail($id);

		DB::beginTransaction();

		if (!$data->delete())
		{
			DB::rollback();

			return Redirect::back()
				->withErrors($data->getError())
				->with('msg-type','danger');
		}
		else
		{
			DB::commit();

			return Redirect::route('backend.data.supplier.index')
				->with('msg', 'Supplier telah dihapus')
				->with('msg-type','success');
		}
	}
    public function getExpiredFromSetting($type)
    {
        $exp_date       = policy::GetExpired(['type' => $type, 'date' => 'now'])->first();
        
        if(empty($exp_date))
        {
            throw new Exception('Setting not found.');
        }

        return $exp_date;
    }


    public function checkIsExpired($exp_date, $transac_date)
    {
        if(date('Y-m-d H:i:s') >= date('Y-m-d H:i:s', strtotime($transac_date . $exp_date)) )
        {
            $result         = new jsend('success', (array)'Expired');        
        }
        else
        {
            $result         = new jsend('success', (array)'Live');        
        }
        return $result;
    }

   public function getSupplierByName()
   {
   	$inputs 	= Input::only('name');
   	
   	$tmp 		= Supplier::select(['id', 'name'])
   					->where('name', 'like', "%" . $inputs['name'] . "%")
   					->get();
   			
   	return json_decode(json_encode($tmp));
   }
}