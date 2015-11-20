<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\BaseController;
use App\Models\Tag;
use Input, Session, DB, Redirect, Response;

class TagController extends BaseController 
{
	protected $view_name 							= 'Tag';

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
															'Pengaturan Tag' 	=> route('backend.settings.tag.index')
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

		$this->layout->page 						= view('pages.backend.settings.tag.index')
															->with('WT_pagetitle', $this->view_name )
															->with('WT_pageSubTitle','Index')
															->with('WB_breadcrumbs', $breadcrumb)
															->with('nav_active', 'settings')
															->with('filters', $filters)
															->with('searchResult', $searchResult)
															->with('subnav_active', 'tag')
														;

		return $this->layout;		
	}

	public function show($id)
	{
		$tag 									= Tag::findorfail($id);

		$breadcrumb									= 	[
															'Pengaturan Tag' 	=> route('backend.settings.tag.index'),
															$tag->name 		=> route('backend.settings.tag.show', $id)
														];

		$this->layout->page 						= view('pages.backend.settings.tag.show')
														->with('WT_pagetitle', $this->view_name )
														->with('WT_pageSubTitle', $tag->name)		
														->with('WB_breadcrumbs', $breadcrumb)
														->with('id', $id)
														->with('tag', $tag)
														->with('nav_active', 'settings')
														->with('subnav_active', 'tag')
													;

		return $this->layout;
	}


	public function create($id = null)
	{

		if($id)
		{
			$tag 								= Tag::findorfail($id);
			$title 									= $tag->name;

			$breadcrumb								= 	[
															'Pengaturan Tag' 	=> route('backend.settings.tag.index'),
															$tag->name 		=> route('backend.settings.tag.edit', $id)
														];
		}
		else
		{
			$tag 								= new Tag;
			$title 									= 'Baru';

			$breadcrumb								= 	[
															'Pengaturan Tag' 	=> route('backend.settings.tag.index'),
															'Baru' 					=> route('backend.settings.tag.create')
														];
		}

		$this->layout->page 						= view('pages.backend.settings.tag.create')
																->with('WT_pagetitle', $this->view_name )
																->with('WT_pageSubTitle',$title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('tag', $tag)
																->with('nav_active', 'settings')
																->with('subnav_active', 'tag');

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
			$data 									= Tag::find($id);
			$inputs['path']							= $data['path'];
		}
		else
		{
			$data 									= new Tag;	
			$inputs['path']							= 0;
		}



		if (Input::get('parent') != 0)
		{
			$data->fill([
				'category_id' 						=> $inputs['parent'],
				'type' 								=> 'tag',
				'name' 								=> $inputs['name'],
				'path'								=> $inputs['parent'],
			]);
		}
		else
		{
			$data->fill([
				'name' 								=> $inputs['name'],
				'type' 								=> 'tag',
				'category_id' 						=> '0',
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

			return Redirect::route('backend.settings.tag.index')
				->with('msg','Tag sudah disimpan')
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
		$data 											= Tag::findorfail($id);

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

			return Redirect::route('backend.settings.tag.index')
				->with('msg', 'Tag telah dihapus')
				->with('msg-type','success')
				;
		}
	}

	public function getTagByName()
	{
		$data 									= new Tag;	

		$name 									= Input::get('name');

		$tmps 									= Tag::where('name', 'like', "%$name%")
																	->get();

		 return json_decode(json_encode($tmps));
	}	

	public function getTagParentByName()
	{
		$inputs 	= Input::only('name','path');
			
		$tmp 		=  Tag::select(array('id', 'name', 'path'))
									->where('name', 'like', "%" . $inputs['name'] . "%");
		 
		if(!empty($inputs['path']))
		{
			$tmp = $tmp->where('path','not like', $inputs['path'].'%');
		}

		$tmp = $tmp->get();

		return json_decode(json_encode($tmp));
	}		
}