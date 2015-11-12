<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use Input, Session, DB, Redirect, Response;

class CategoryController extends BaseController 
{
	protected $view_name 							= 'Kategori';

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
		$breadcrumb									= 	[
															'Pengaturan Kategori' 	=> route('backend.settings.category.index')
														];

		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['name' => Input::get('q')];

			$searchResult							= Input::get('q');
		}
		else
		{
			$searchResult							= null;
		}

		$this->layout->page 						= view('pages.backend.settings.category.index')
															->with('WT_pagetitle', $this->view_name )
															->with('WT_pageSubTitle','Index')
															->with('WB_breadcrumbs', $breadcrumb)
															->with('nav_active', 'settings')
															->with('filters', $filters)
															->with('searchResult', $searchResult)
															->with('subnav_active', 'category')
														;

		return $this->layout;		
	}

	public function show($id)
	{
		$category 									= Category::findorfail($id);

		$breadcrumb									= 	[
															'Pengaturan Kategori' 	=> route('backend.settings.category.index'),
															$category->name 		=> route('backend.settings.category.show', $id)
														];

		$this->layout->page 						= view('pages.backend.settings.category.show')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle', $category->name)		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('id', $id)
														->with('category', $category)
														->with('nav_active', 'settings')
														->with('subnav_active', 'category')
													;

		return $this->layout;
	}


	public function create($id = null)
	{

		if($id)
		{
			$category 								= Category::findorfail($id);
			$title 									= $category->name;

			$breadcrumb								= 	[
															'Pengaturan Kategori' 	=> route('backend.settings.category.index'),
															$category->name 		=> route('backend.settings.category.edit', $id)
														];
		}
		else
		{
			$category 								= new Category;
			$title 									= 'Baru';

			$breadcrumb								= 	[
															'Pengaturan Kategori' 	=> route('backend.settings.category.index'),
															'Baru' 					=> route('backend.settings.category.create')
														];
		}

		$this->layout->page 						= view('pages.backend.settings.category.create')
																->with('WT_pagetitle', $this->view_name )
																->with('WT_pageSubTitle',$title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('category', $category)
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

	public function update($id)
	{
		return $this->store($id);		
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