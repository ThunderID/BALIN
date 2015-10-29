<?php namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\baseController;
use Input, Session, DB, Redirect, Response;
use App\Models\StoreSetting;
use Illuminate\Support\MessageBag;

class StoreController extends baseController 
{
	protected $view_name 					= 'Toko Online';

	public function index()
	{		
		$breadcrumb								= 	[
														'Pengaturan Toko Online' => 'backend.settings.store.index'
													];

		$searchResult							= NULL;

		$this->layout->page 					= view('pages.backend.settings.store.index')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle','Edit')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('searchResult', $searchResult)
													->with('nav_active', 'settings')
													->with('subnav_active', 'store')
													;

		return $this->layout;		
	}

	public function show($id)
	{
		return Redirect::back();
	}

	public function create($id = null)
	{
		$page 									= StoreSetting::id($id)->type('pages')->first();

		if(!$page)
		{
			App::abort(404);
		}

		if ($id)
		{
			$breadcrumb							= 	[	
														'Pengaturan '.ucwords(str_replace('-', ' ', $page->url))	=> route('backend.settings.store.edit', $id),
													];
		}
		else
		{
			$breadcrumb							= [
														'Pengaturan Baru' 			=> 'backend.settings.store.create' 
													];
		}

		$this->layout->page 					= view('pages.backend.settings.store.create')
													->with('WT_pagetitle', $this->view_name )
													->with('WT_pageSubTitle', ucwords(str_replace('-', ' ', $page->url)))
													->with('WB_breadcrumbs', $breadcrumb)
													->with('id', $id)
													->with('page', $page)
													->with('nav_active', 'settings')
													->with('subnav_active', 'store')
													;

		return $this->layout;
				
	}

	public function edit($id)
	{
		return $this->create($id);		
	}

	public function store($id = null)
	{
		$errors 								= new MessageBag();

		$settings 								= StoreSetting::type(['url', 'logo', 'facebook_url', 'twitter_url', 'email', 'phone', 'address', 'bank_information'])->get();
		
		foreach ($settings as $key => $value) 
		{
			if(Input::has(strtolower($value['type'])))
			{
				$setting 						= StoreSetting::findorfail($value->id);
				if($value['type'] == 'phone' || $value['type'] == 'address' || $value['type'] == 'bank_information')
				{
					$setting->fill(['content' => Input::get(strtolower($value['type']))]);
				}
				else
				{
					$setting->fill(['url' => Input::get(strtolower($value['type']))]);
				}
				
				if(!$setting->save())
				{
					$errors->add('Store', $setting->getError());
				}
			}
		}

		if (!$errors->count())
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

			return Redirect::route('backend.settings.store.index')
				->with('msg','Pengaturan toko online sudah disimpan')
				->with('msg-type', 'success');
		}
	}

	public function update($id)
	{
		$errors 								= new MessageBag();

		$setting 								= StoreSetting::findorfail($id);
		
		$setting->fill(['content' => Input::get('content')]);
				
		if(!$setting->save())
		{
			$errors->add('Store', $setting->getError());
		}

		if (!$errors->count())
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

			return Redirect::route('backend.settings.store.edit', $id)
				->with('msg','Pengaturan toko online sudah disimpan')
				->with('msg-type', 'success');
		}
	}

	public function destroy($id)
	{
		return Redirect::back();
	}
}