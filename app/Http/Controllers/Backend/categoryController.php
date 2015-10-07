<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\category;
use Input, Session, DB, Redirect, Response;

class categoryController extends baseController 
{
	protected $view_name 						= 'Category';

	public function index()
	{		
		$datas									= category::orderBy('path','asc')->paginate();
		$breadcrumb								= ['Kategori' => 'backend.category.index'];
		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.category.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult)
													;

		return $this->layout;		
	}

	public function show($id)
	{
		if($id)
		{
			$breadcrumb								= [	'Kategori' => 'backend.category.index',
														'Detail' => 'backend.category.show' ];

			$data									= category::where('id', $id)->with('products')->first();

			if(count($data) == 0)
			{
				App::abort(404);
			}

			$this->layout->page 					= view('pages.backend.category.detail')
														->with('WT_pageTitle', $this->view_name )
														->with('WT_pageSubTitle','Detail')		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('data', $data)
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
			$breadcrumb							= [ 'Kategori' => 'backend.category.index',
													'Edit Data' => 'backend.category.create' ];
			$data 								= category::with('category')->where('categories.id', Input::get('id'))->first();

			if (count($data) == 0)
			{
				App::abort(404);
			}
		}
		else
		{
			$breadcrumb							= [	'Kategori' => 'backend.category.index',
													'Data Baru' => 'backend.category.create' ];

			$data								= NULL;
		}

		$this->layout->page 					= view('pages.backend.category.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Create')		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('data', $data)
													;

		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);		
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('id','name', 'parent');

		if ($id)
		{
			$data 								= Category::find($id);
			$inputs['path']						= $data['path'];
		}
		else
		{
			$data 								= new Category;	
			$inputs['path']						= 0;
		}

		$data->fill([
			'name' 								=> $inputs['name'],
			'path'								=> $inputs['id']
		]);

		if (Input::get('parent') != 0)
		{
			$data->category()->associate($inputs['parent']);
		}
		else
		{
			$data->fill([
				'parent_id' 					=> '0',
				'path'							=> '0'
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
				return Redirect::route('backend.category.index')
					->with('msg','Data sudah diperbarui')
					->with('msg-type', 'success')
					;
			}
			else
			{
				return Redirect::route('backend.category.index')
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
				return Redirect::route('backend.category.index')
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
													->findCategory(0)
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
	    $inputs = Input::only('name','path');
	    
	    $tmp =  Category::select(array('id', 'name', 'path'))
	    		->where('name', 'like', "%" . $inputs['name'] . "%");
	    
	    if(!empty($inputs['path']))
	    {
	    	$tmp = $tmp
			    ->where('path','not like', $inputs['path'].'%')
			    ;
	    }

	    $tmp = $tmp->get();
	    return json_decode(json_encode($tmp));
	}		
}