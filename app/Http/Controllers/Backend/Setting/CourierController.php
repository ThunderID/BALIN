<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use Illuminate\Support\MessageBag;
use App\Models\Courier;
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

	protected $view_name 								= 'Courier';

	public function index()
	{		
		$breadcrumb										= ['Kurir' => 'backend.settings.courier.index'];


		$this->layout->page 							= view('pages.backend.settings.courier.index')
																	->with('WT_pageTitle', $this->view_name )
																	->with('WT_pageSubTitle','Index')
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('nav_active', 'settings')
																	->with('subnav_active', 'courier');
		return $this->layout;		
	}

	public function show($id)
	{
		
	}


	public function create($id = null)
	{
		if (is_null($id))
		{
			$breadcrumb									= 	[	'Kurir' => 'backend.settings.courier.index',
																'Kurir Baru' => 'backend.settings.courier.create'
															];
		}
		else
		{
			$breadcrumb									= 	[	'Kurir' => 'backend.settings.courier.index',
																'Edit Data' => 'backend.settings.courier.create'
															];
		}

		$this->layout->page 							= view('pages.backend.settings.courier.create')
																	->with('WT_pageTitle', $this->view_name )
																	->with('WT_pageSubTitle','Create')		
																	->with('WB_breadcrumbs', $breadcrumb)
																	->with('id', $id)
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
		$inputs 										= Input::only('name', 'address');

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
			'address' 									=> $inputs['address'],
		]);

		DB::beginTransaction();
		
		$errors 										= new MessageBag();

		if(!$data->save())
		{
			$errors->add('Courier', $data->gerError());
		}

		$image 											= new Image;
		$image->fill([
				'thumbnail'								=> $inputs['logo_url'],
				'image_xs'								=> $inputs['logo_url'],
				'image_sm'								=> $inputs['logo_url'],
				'image_md'								=> $inputs['logo_url'],
				'image_l'								=> $inputs['logo_url'],
				'published_at'							=> date('Y-m-d H:i:s'),
		]);

		if (!$image->save())
		{
			$errors->add('Courier', $image->gerError());
		}

		$image->imageable()->associate($data);
		
		if (!$image->save())
		{
			$errors->add('Courier', $image->gerError());
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

	public function destroy($id)
	{
		if (Input::get('password'))
		{		
			$data									= Courier::find($id);

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
					->with('msg-type','danger');
			}
			else
			{
				DB::commit();
				return Redirect::route('backend.settings.courier.index')
					->with('msg', 'Data telah dihapus')
					->with('msg-type','success');
			}
		}
		else
		{
			return Redirect::back()
					->withErrors('Password tidak valid')
					->with('msg-type', 'danger');
		}		
	}

}