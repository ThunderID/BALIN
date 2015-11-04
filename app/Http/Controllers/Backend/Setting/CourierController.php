<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use Illuminate\Support\MessageBag;
use App\Models\Courier;
use App\Models\Address;
use App\Models\Image;
use Input, Session, DB, Redirect, Response;

class CourierController extends baseController 
{
    /**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 							= 'Kurir';

	public function index()
	{		
		$breadcrumb									= 	[
															'Pengaturan Kurir' => route('backend.settings.courier.index')
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

		$this->layout->page 							= view('pages.backend.settings.courier.index')
																	->with('WT_pagetitle', $this->view_name )
																	->with('WT_pageSubTitle','Index')
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('nav_active', 'settings')
																	->with('filters', $filters)
																	->with('searchResult', $searchResult)
																	->with('subnav_active', 'courier');
		return $this->layout;		
	}

	public function show($id)
	{
		$courier 									= Courier::findorfail($id);

		$breadcrumb									= 	[
															'Pengaturan Kurir' 	=> route('backend.settings.courier.index'),
															$courier->name 		=> route('backend.settings.courier.show', $id),
														];

		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['postalcode' => Input::get('q')];
			
			$searchResult							= Input::get('q');
		}
		else
		{
			$searchResult							= null;
		}

		$this->layout->page 							= view('pages.backend.settings.courier.show')
																		->with('WT_pagetitle', $this->view_name )
																		->with('WT_pageSubTitle',$courier->name)
																		->with('WB_breadcrumbs', $breadcrumb)
																		->with('searchResult', $searchResult)
																		->with('id', $id)
																		->with('courier', $courier)
																		->with('filters', $filters)
																		->with('nav_active', 'settings')
																		->with('subnav_active', 'courier')
																		;

		return $this->layout;
	}


	public function create($id = null)
	{
		if (is_null($id))
		{
			$courier 								= new Courier;

			$breadcrumb								= 	[
															'Pengaturan Kurir' 			=> route('backend.settings.courier.index'),
															'Baru'						=> route('backend.settings.courier.create'),
														];

			$title 									= 'Baru';
		}
		else
		{
			$courier 								= Courier::findorfail($id);

			$breadcrumb								= 	[
															'Pengaturan Kurir' 			=> route('backend.settings.courier.index'),
															'Edit '.$courier->name 		=> route('backend.settings.courier.edit', $id),
														];

			$title 									= $courier->name;
		}

		$this->layout->page 						= view('pages.backend.settings.courier.create')
																	->with('WT_pagetitle', $this->view_name )
																	->with('WT_pageSubTitle',$title)		
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('id', $id)
																	->with('courier', $courier)
																	->with('nav_active', 'settings')
																	->with('subnav_active', 'courier');
		return $this->layout;		
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 										= Input::only('address_id', 'name', 'address', 'phone', 'zipcode');
		$images 										= Input::only('thumbnail', 'image_xs','image_sm','image_md','image_lg');

		$colors 										= ['ffcccc', 'ccccff', 'fffdcc', 'ddffcc', 'ffccfc', '000000', 'bababa', '00ffae', 'a0000a', '00fff0'];
		$inputs['logo_url']								= 'http://placehold.it/200x200/'.$colors[rand(0, count($colors)-1)].'/000000';

		if(!is_null($id))
		{
			$data										= Courier::find($id);
		}
		else
		{
			$data										= new Courier;
		}

		$data->fill([
			'name' 										=> $inputs['name'],
		]);


		DB::beginTransaction();
		
		$errors 										= new MessageBag();

		if(!$data->save())
		{
			$errors->add('Courier', $data->getError());
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
			$errors->add('Courier', $image->getError());
		}

		$image->imageable()->associate($data);
		
		if (!$image->save())
		{
			$errors->add('Courier', $image->getError());
		}

		if($inputs['address_id'])
		{
			$address						= Address::find($inputs['address_id']);			
		}
		else
		{
			$address						= new Address;			
		}

		$address->fill([
			'phone' 						=> $inputs['phone'],
			'zipcode' 						=> $inputs['zipcode'],
			'address' 						=> $inputs['address'],
		]);

		$address->owner()->associate($data);

		if(!$address->save())
		{
			$errors->add('Address', $address->getError());
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

			return Redirect::route('backend.settings.courier.index')
								->with('msg', 'Kurir sudah disimpan')
								->with('msg-type', 'success');
		}	
	}

	public function Update($id)
	{
		return $this->store($id);		
	}

	public function destroy($id)
	{
		$data											= Courier::findorfail($id);

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

			return Redirect::route('backend.settings.courier.index')
				->with('msg', 'Kurir sudah dihapus')
				->with('msg-type','success');
		}
	}

	public function getCourierByName()
	{
		$inputs		= Input::only('name');
		$tmp 			= Courier::select(['id', 'name'])
								->where('name', 'like', '%'. $inputs['name'].'%')
								->get();

		return json_decode(json_encode($tmp));
	}

}