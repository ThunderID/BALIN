<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use App\Models\Category;
use Input, Session, DB, Redirect, Response;

class CategoryController extends baseController 
{
	protected $view_name 							= 'Category';

    /**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	public function index()
	{		
		$breadcrumb									= ['Kategori' => 'backend.settings.category.index'];

		$this->layout->page 						= view('pages.backend.settings.category.index')
															->with('WT_pageTitle', $this->view_name )
															->with('WT_pageSubTitle','Index')
															->with('WB_breadcrumbs', $breadcrumb)
															->with('nav_active', 'settings')
															->with('subnav_active', 'category')
														;

		return $this->layout;		
	}

	public function show($id)
	{
		if($id)
		{
			$breadcrumb								= 	[	'Kategori' => 'backend.settings.category.index',
															'Detail' => 'backend.settings.category.show'
														];

			$this->layout->page 					= view('pages.backend.settings.category.detail')
															->with('WT_pageTitle', $this->view_name )
															->with('WT_pageSubTitle','Detail')		
															->with('WB_breadcrumbs', $breadcrumb)
															->with('id', $id)
															->with('nav_active', 'settings')
															->with('subnav_active', 'category')
														;

			return $this->layout;
		}
		else
		{
			App::abort(404);
		}
	}


	public function create($id = null)
	{

		if($id)
		{
			$breadcrumb								= 	[	'Kategori' 	=> 'backend.settings.category.index',
															'Edit Data' => 'backend.settings.category.create'
														];
		}
		else
		{
			$breadcrumb								= 	[	'Kategori' 	=> 'backend.settings.category.index',
															'Data Baru' => 'backend.settings.category.create' 
														];
		}

		$this->layout->page 						= view('pages.backend.settings.category.create')
																->with('WT_pageTitle', $this->view_name )
																->with('WT_pageSubTitle','Create')		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('nav_active', 'settings')
																->with('subnav_active', 'category');

		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);		
	}

	public function store($id = null)
	{
		$inputs 									= Input::only('name', 'parent');

		if ($id)
		{
			$data 									= Category::find($id);
			$inputs['path']							= $data['path'];
		}
		else
		{
			$data 									= new Category;	
			$inputs['path']							= 0;
		}



		if (Input::get('parent') != 0)
		{
			$data->fill([
				'category_id' 						=> $inputs['parent'],
				'name' 								=> $inputs['name'],
				'path'								=> $inputs['parent'],
			]);
		}
		else
		{
			$data->fill([
				'name' 								=> $inputs['name'],
				'parent_id' 						=> '0',
				'path'								=> '0'
			]);
		}

		DB::beginTransaction();

		if (!$data->save())
		{
			DB::rollback();

			return Redirect::back()
					->withInput()
					->withErrors($data->getError())
					->with('msg-type', 'danger')
					;
		}
		else
		{
			DB::commit();

			return Redirect::route('backend.settings.category.index')
				->with('msg','Kategori sudah disimpan')
				->with('msg-type', 'success')
				;
		}
	}

	public function destroy($id)
	{
		$data 											= Category::findorfail($id);

		DB::beginTransaction();

		if (!$data->delete())
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

			return Redirect::route('backend.settings.category.index')
				->with('msg', 'Kategori telah dihapus')
				->with('msg-type','success')
				;
		}
	}

	public function getCategoryByName()
	{
		$data 									= new Category;	

		$name 									= Input::get('name');

		$tmps 									= Category::where('name', 'like', "%$name%")
																	->get();

		 return json_decode(json_encode($tmps));
	}	

	public function getCategoryParentByName()
	{
		$inputs 	= Input::only('name','path');
			
		$tmp 		=  Category::select(array('id', 'name', 'path'))
									->where('name', 'like', "%" . $inputs['name'] . "%");
		 
		if(!empty($inputs['path']))
		{
			$tmp = $tmp->where('path','not like', $inputs['path'].'%');
		}

		$tmp = $tmp->get();

		return json_decode(json_encode($tmp));
	}		
}