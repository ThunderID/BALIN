<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

use Input, Redirect, Auth, Carbon, Validator, DB;
use App\Models\Address;

class AddressController extends BaseController 
{
	protected $controller_name 					= 'profile';

	public function index()
	{	
		$address 								= Auth::user()->addresses;

		if(isset($address[0]))
		{
			return $this->create($address[0]['id']);
		}

		return $this->create(null);
		$this->layout->page 					= view('pages.frontend.user.address.index')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_address')
													->with('title', 'Buku Alamat');

		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}	

	public function create($id = null)
	{	
		$address 								= Address::findornew($id);

		$subtitle 								= 'baru';

		if(!is_null($id))
		{
			$subtitle 							= 'ubah';
		}
	
		$this->layout->page 					= view('pages.frontend.user.address.create')
													->with('controller_name', $this->controller_name)
													->with('subnav_active', 'account_address')
													->with('title', 'Buku Alamat')
													->with('subtitle', $subtitle)
													->with('address', $address)
													->with('id', $id)
													;

		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('phone', 'address', 'zipcode');

		$address 								= Address::findornew($id);

		$address->fill($inputs);

		$address->owner()->associate(Auth::user());
		
		if(!$address->save())
		{
			return Redirect::back()->withErrors($address->getError())
							->with('msg-type', 'danger')
							;
		}

		return Redirect::route('frontend.profile.address.index')
				->with('msg','Alamat sudah disimpan')
				->with('msg-type', 'success');
	}

	public function edit($id)
	{		
		return $this->create($id);
	}

	public function update($id)
	{		
		return $this->store($id);
	}
}