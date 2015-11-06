<?php namespace App\Http\Controllers\Backend\Data;
use App\Http\Controllers\baseController;

use App\Models\PointLog;
use App\Models\User;

use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect, Carbon;

class PointLogController extends baseController 
{

    /**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 								= 'Point';

	public function index()
	{
		return Redirect::back();
	}

	public function create($user_id = null, $id = null)
	{
		$user 											= User::findorfail($user_id);

		
		$breadcrumb										= 	[	
																$user->name 	=> route('backend.data.customer.show', $user_id),
																'Point' 		=> route('backend.data.pointlog.index', ['user_id', $user_id])
															];

		if($id) 
		{	
			$breadcrumb['Edit'] 						= route('backend.data.pointlog.edit', [$id, 'user_id' => $user_id]);

			$title 										= 	'Edit';
		}
		else
		{
			$breadcrumb['Baru'] 						= route('backend.data.pointlog.create', [$id, 'user_id' => $user_id]);

			$title 										= 	'Baru';
		}

		$this->layout->page 							= view('pages.backend.data.pointlog.create')
																->with('WT_pagetitle', $this->view_name )
																->with('WT_pageSubTitle', $title)		
																->with('WB_breadcrumbs', $breadcrumb)
																->with('id', $id)
																->with('user', $user)
																->with('user_id', $user_id)
																->with('nav_active', 'data')
																->with('subnav_active', 'customer');

		return $this->layout;		
	}


	public function show($user_id, $id)
	{
		return Redirect::back();
	}	

	public function edit($user_id, $id)
	{
		return $this->create($user_id, $id);
	}	

	public function store($user_id = null, $id = null)
	{
		$user_id 										= Input::get('user_id');

		$inputs 										= Input::only('user_id','amount','notes','date','time');

		if (Input::get('id'))
		{
			$data 										= PointLog::findorfail(Input::get('id'));
		}
		else
		{
			$data 										= new PointLog;	
		}

		$expired_at 									= Carbon::createFromFormat('Y-m-d', $inputs['date'])->format('Y-m-d').' '.Carbon::createFromFormat('H:i', $inputs['time'])->format('H:i:s');

		$data->fill([
			'user_id' 									=> $inputs['user_id'],
			'amount' 									=> $inputs['amount'],
			'notes' 									=> $inputs['notes'],
			'expired_at'								=> $expired_at,
		]);

		DB::beginTransaction();

		if (!$data->save())
		{
			DB::rollback();
			
			return Redirect::back()
					->withErrors($data->getError())
					->with('msg-type', 'danger')
					;
		}
		else
		{
			DB::commit();

			return Redirect::route('backend.data.customer.show', $user_id)
					->with('msg','Data sudah disimpan')
					->with('msg-type', 'success')
					;
		}
	}

	public function destroy($id)
	{
		$data 								= PointLog::findorfail($id);

		$user_id 							= Input::get('user_id');

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

			return Redirect::route('backend.data.pointlog.index', $user_id)
				->with('msg', 'Produk telah dihapus')
				->with('msg-type','success');
		}
	}	

	public function Update($user_id, $id)
	{
		return $this->store($user_id, $id);		
	}

}