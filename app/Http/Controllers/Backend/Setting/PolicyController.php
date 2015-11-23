<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\BaseController;
use Input, Session, DB, Redirect, Response, Carbon;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class PolicyController extends BaseController 
{
	/**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Policy';

	public function index()
	{		
		$breadcrumb								= 	[
														'Pengaturan Policy' 	=> route('backend.settings.policies.index')
													];

		$filters								= null;

		if(Input::has('q'))
		{
			$filters 							= ['ondate' => Input::get('q')];
			
			$searchResult						= Input::get('q');
		}
		else
		{
			$searchResult						= null;
		}

		$this->layout->page 					= view('pages.backend.settings.policy.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('filters', $filters)
													->with('nav_active', 'settings')
													->with('subnav_active', 'policy')
													;

		return $this->layout;		
	}

	public function show($id)
	{
		return Redirect::back();
	}


	public function create($id = null)
	{
		if ($id)
		{
			$breadcrumb							= 	[
														'Pengaturan Policy' 	=> route('backend.settings.policies.index'),
														'Ubah' 					=> route('backend.settings.policies.create'),
													];
		}
		else
		{
			$breadcrumb							= 	[
														'Pengaturan Policy' 	=> route('backend.settings.policies.index'),
														'Ubah' 					=> route('backend.settings.policies.create'),
													];
		}

		$this->layout->page 					= view('pages.backend.settings.policy.create')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('id', $id)
													->with('nav_active', 'settings')
													->with('subnav_active', 'policy')
													;

		return $this->layout;
				
	}

	public function edit($id)
	{
		return Redirect::back();
	}

	public function store($id = null)
	{
		$errors 								= new MessageBag();

		$inputs 								= Input::all();

		foreach ($inputs['type'] as $key => $value) 
		{
			if($inputs['value'][$key]!='')
			{
				$policy 						= StoreSetting::findOrNew($inputs['id'][$key]);

				$started_at 					= date("Y-m-d H:i:s", strtotime($inputs['start'][$key]));

				$policy->fill([
					'type'						=> $value,
					'value'						=> $inputs['value'][$key],
					'started_at'				=> $started_at,
				]);
				
		        if($policy->getDirty())
		        {
		        	$data 						= new StoreSetting; 

					$data->fill([
						'type'					=> $value,
						'value'					=> $inputs['value'][$key],
						'started_at'			=> $started_at,
					]);

					if(!$data->save())
					{
						$errors->add('Store', $data->getError());
					}
		        }
			}
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

			return Redirect::route('backend.settings.policies.index')
				->with('msg','Pengaturan policy sudah disimpan')
				->with('msg-type', 'success');
		}
	}

	public function update($id)
	{
		return Redirect::back();
	}

	public function destroy($id)
	{
		return Redirect::back();
	}
}