<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use Input, Session, DB, Redirect, Response;
use Illuminate\Support\MessageBag;
use App\Models\StoreSetting;

class PolicyController extends baseController 
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

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.settings.policy.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
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
													->with('subnav_active', 'store')
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
				$policy 						= new StoreSetting;

				$policy->fill([
					'type'						=> $value,
					'value'						=> $inputs['value'][$key],
					'started_at'				=> $inputs['start'][$key],
				]);
				
				if(!$policy->save())
				{
					$errors->add('Store', $policy->getError());
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