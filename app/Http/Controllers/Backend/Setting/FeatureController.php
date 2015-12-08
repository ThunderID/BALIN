<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\BaseController;
use Illuminate\Support\MessageBag;
use App\Models\storeSetting;
use App\Models\Image;
use Input, Session, DB, Redirect, Response;

class FeatureController extends BaseController 
{
    /**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 							= 'Toko Online';

	public function index()
	{		
		$breadcrumb									= 	[
															'Pengaturan Etalase' => route('backend.settings.feature.index')
														];

		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['ondate' => Input::get('q')];
			
			$searchResult							= Input::get('q');
		}
		else
		{
			$searchResult							= null;
		}

		$this->layout->page 							= view('pages.backend.settings.feature.index')
																	->with('WT_pagetitle', $this->view_name )
																	->with('WT_pageSubTitle','Etalase')
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('nav_active', 'settings')
																	->with('filters', $filters)
																	->with('searchResult', $searchResult)
																	->with('subnav_active', 'store');
		return $this->layout;		
	}

	public function show($id)
	{
		return Redirect::back();
	}


	public function create($id = null)
	{
		if (is_null($id))
		{
			$feature 								= new storeSetting;

			$breadcrumb								= 	[
															'Pengaturan Etalase' 			=> route('backend.settings.feature.index'),
															'Baru'							=> route('backend.settings.feature.create'),
														];

			$title 									= 'Baru';
		}
		else
		{
			$feature 								= storeSetting::findorfail($id);

			$breadcrumb								= 	[
															'Pengaturan Etalase' 			=> route('backend.settings.feature.index'),
															'Edit '.$feature->name 			=> route('backend.settings.feature.edit', $id),
														];

			$title 									= $feature->name;
		}

		$this->layout->page 						= view('pages.backend.settings.feature.create')
																	->with('WT_pagetitle', $this->view_name )
																	->with('WT_pageSubTitle',$title)		
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('id', $id)
																	->with('feature', $feature)
																	->with('nav_active', 'settings')
																	->with('subnav_active', 'store');
		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		$action 										= Input::get('action');

		$inputs 										= Input::only('title_active', 'slider_title_location', 'slider_title','content_active', 'slider_content_location', 'slider_content' , 'button_active' ,'slider_button_location','slider_button_text', 'slider_button_url', 'started_at', 'ended_at');
		$images 										= Input::only('thumbnail', 'image_xs','image_sm','image_md','image_lg');


		$title 											= ['title_active'					=> 0];
		$content										= ['content_active'					=> 0];
		$button											= ['button_active'					=> 0];

		if($inputs['title_active'] == 1)
		{
			$title 										= 	[
																'title_active'				=> $inputs['title_active'],
																'slider_title_location'		=> $inputs['slider_title_location'],
																'slider_title'				=> $inputs['slider_title'],
															];
		}

		if($inputs['content_active'] == 1)
		{
			$content 									= 	[
																'content_active'			=> $inputs['content_active'],
																'slider_content_location'	=> $inputs['slider_content_location'],
																'slider_content'			=> $inputs['slider_content'],
															];
		}

		if($inputs['button_active'] == 1)
		{
			$button 									= 	[
																'button_active'				=> $inputs['button_active'],
																'slider_button_location'	=> $inputs['slider_button_location'],
																'slider_button'				=> $inputs['slider_button_text'],
																'slider_button_url'			=> $inputs['slider_button_url'],
															];
		}
		else
		{
			$button 									=	[
																'button_active'				=> 0,
																'slider_button_url'			=> $inputs['slider_button_url'],
															];
		}			

		$value											= 	[ 'title' => $title, 'content' => $content, 'button' => $button];


		if($action == 'preview')
		{
			return $this->preview($images, $value);		
		}															

		if(!is_null($id))
		{
			$data										= storeSetting::find($id);
		}
		else
		{
			$data										= new storeSetting;
		}

		$started_at 									= date("Y-m-d H:i:s", strtotime($inputs['started_at']));
		$ended_at 										= date("Y-m-d H:i:s", strtotime($inputs['ended_at']));

		$data->fill([
			'type'										=> 'slider',
			'value'										=> json_encode($value),
			'started_at' 								=> $started_at,
			'ended_at' 									=> $ended_at,
		]);

		DB::beginTransaction();
		
		$errors 										= new MessageBag();

		if(!$data->save())
		{
			$errors->add('FeaturedProduct', $data->getError());
		}

		$image 											= new Image;

		$image->fill([
				'thumbnail'								=> $images['thumbnail'],
				'image_xs'								=> $images['image_xs'],
				'image_sm'								=> $images['image_sm'],
				'image_md'								=> $images['image_md'],
				'image_lg'								=> $images['image_lg'],
				'published_at'							=> date('Y-m-d H:i:s'),
		]);

		if (!$image->save())
		{
			$errors->add('FeaturedProduct', $image->getError());
		}

		$image->imageable()->associate($data);
		
		if (!$image->save())
		{
			$errors->add('FeaturedProduct', $image->getError());
		}		

		if ($errors->count())
		{
			DB::rollback();

			return Redirect::back()
								->withInput()
								->withErrors($errors)
								->with('msg-type', 'danger');
		}	
		else
		{
			DB::commit();

			return Redirect::route('backend.settings.feature.index')
								->with('msg', 'Etalase sudah disimpan')
								->with('msg-type', 'success');
		}	
	}

	public function Update($id)
	{
		return $this->store($id);		
	}

	public function destroy($id)
	{
		$data											= storeSetting::findorfail($id);

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

			return Redirect::route('backend.settings.feature.index')
				->with('msg', 'Etalase sudah dihapus')
				->with('msg-type','success');
		}
	}

	public function showPreview($id)
	{
		$data 			= StoreSetting::findorfail($id);

		$images 		= null;
		if(isset($data['images'][0]))
		{
			$images 	= $data['images'][0];
		}

		$value 			= null;
		if(isset($data['value']))
		{
			$value 		= (array)json_decode($data['value'], true);
		}

		return $this->preview($images, $value);
	}


	public function preview($images, $value)
	{
		//notes
		//variable images utk image slider
		//variable value utk content slider
		return  view('pages.backend.settings.feature.preview')
					->with('images', $images)
					->with('value', $value);
	}
}