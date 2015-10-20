<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use App\Models\Category;
use Input, Session, DB, Redirect, Response;

class categoryController extends baseController 
{
	protected $view_name 						= 'Category';

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
			$breadcrumb								= ['Kategori' => 'backend.settings.category.index',
															'Detail' => 'backend.settings.category.show' ];

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

		if ($id)
		{
			$breadcrumb								= ['Kategori' => 'backend.settings.category.index',
															'Edit Data' => 'backend.settings.category.create' ];
		}
		else
		{
			$breadcrumb								= ['Kategori' => 'backend.settings.category.index',
															'Data Baru' => 'backend.settings.category.create' ];
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
		$inputs 										= Input::only('id','name', 'parent');

		if ($inputs['id'])
		{
			$data 									= Category::find($inputs['id']);
			$inputs['path']						= $data['path'];
		}
		else
		{
			$data 									= new Category;	
			$inputs['path']						= 0;
		}

		$data->fill([
			'name' 									=> $inputs['name'],
			'path'									=> $inputs['id'],
		]);

		if (Input::get('parent') != 0)
		{
			$data->category()->associate($inputs['parent']);
		}
		else
		{
			$data->fill([
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
			if (Input::get('id'))
			{
				return Redirect::route('backend.settings.category.index')
					->with('msg','Data sudah diperbarui')
					->with('msg-type', 'success')
					;
			}
			else
			{
				return Redirect::route('backend.settings.category.index')
						->with('msg','Data sudah ditambahkan')
						->with('msg-type', 'success')
						;
			}
		}
	}

	public function destroy($id)
	{
		if (Input::get('password'))
		{
			$data 								= Category::find($id);

			if (count($data) == 0)
			{
				App::abort(404);
			}

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
					->with('msg', 'Data telah dihapus')
					->with('msg-type','success')
					;
			}
		}
		else
		{
			return Redirect::back()
					->withErrors('Password tidak valid')
					->with('msg-type', 'danger')
					;
		}

	}

	public function getCategoryByName()
	{
		$data 									= new Category;	

		$name 									= Input::get('name');

		$tmps 									= Category::where('name', 'like', "%$name%")
																	->get();

		// if(count($tmps) > 0)
		// {
			
		// 	for ($i = 0; $i < count($tmps); $i++) 
		// 	{
		// 		$parent_id 						= $tmps[$i]['parent_id'];

		// 		$name 							= category::findorfail($parent_id);
				
		// 		$tmps[$i]['name']				= $name['name'] . ' - ' . $tmps[$i]['name'];
		// 	}
		// }

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