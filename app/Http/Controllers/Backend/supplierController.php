<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Supplier;
use App\Models\policy;
use App\Libraries\JSend;
use App\jobs\TransactionIsExpired;
use Input, Session, DB, Redirect, Response;

class supplierController extends Controller 
{
	protected $view_name 						= 'Supplier';
	protected $transaction;

	public function index()
	{	
		$this->transaction = transaction::find(1);

		// checking
        if(is_null($this->transaction->id))
        {
            throw new Exception('Sent variable must be object of a record.');
        }

        //get case status transaction
        $transac_date           = $this->transaction['transacted_at'];

        switch ($this->transaction['status']) 
        {
            case 'waiting':
                $exp_date       = $this->getExpiredFromSetting('expired_draft');
                $result         = $this->checkIsExpired($exp_date['value'], $transac_date);
                break;
            case 'hold':
                $exp_date       = $this->getExpiredFromSetting('expired_holded');
                $result         = $this->checkIsExpired($exp_date['value'], $transac_date);
                break;
            case 'paid':
                $exp_date       = $this->getExpiredFromSetting('expired_paid');
                $result         = $this->checkIsExpired($exp_date['value'], $transac_date);
                break;
            case 'shipped':
                $exp_date       = $this->getExpiredFromSetting('expired_shipped');
                $result         = $this->checkIsExpired($exp_date['value'], $transac_date);
                break;
            case 'delivered':
                $result         = new jsend('fail', (array)'Transaction has been completed');        
                break;
            case 'canceled':
                $result         = new jsend('fail', (array)'Transaction has been cancelled');        
                break;
            default:
                $result         = new jsend('fail', (array)'Transaction status not found');        
                break;
        }
        return($result);

		// $transaction = transaction::find(1);
		// $this->dispatch(new TransactionIsExpired($transaction));

		// $data = transaction::find(1);
		// $data->save();

		// $breadcrumb										= ['Supllier' => 'backend.supplier.index'];

		// if (Input::get('q'))
		// {
		// 	$datas 											= supplier::where('name','like','%'.Input::get('q').'%')
		// 																				->where('deleted_at',null)
		// 																				->paginate(); 
		// 	$searchResult								= Input::get('q');
		// }
		// else
		// {
		// 	$searchResult								= NULL;
		// }

		$this->layout->page 					= view('pages.frontend.home');
		// 																	->with('WT_pageTitle', $this->view_name )
		// 																	->with('WT_pageSubTitle','Index')
		// 																	->with('WB_breadcrumbs', $breadcrumb)
		// 																	->with('searchResult', $searchResult)
		// 																	->with('nav_active', 'supplier');
		return $this->layout;		
	}

	public function show($id)
	{
		
	}


	public function create($id = null)
	{
		if (!$id)
		{
			$breadcrumb							= [	'Supplier' => 'backend.supplier.index',
													'Supplier Baru' => 'backend.supplier.create' ];
		}
		else
		{
			$breadcrumb							= [ 'Supplier' => 'backend.supplier.index',
													'Edit Data' => 'backend.supplier.create' ];
		}

		$this->layout->page 					= view('pages.backend.supplier.create')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Create')		
													->with('WB_breadcrumbs', $breadcrumb)
													->with('id', $id)
													->with('nav_active', 'supplier');
		return $this->layout;		
	}

	public function edit($id)
	{

		return $this->create($id);
	}

	public function store($id = null)
	{
		$inputs 								= Input::only('id','name', 'phone', 'address');
	
		if ($id)
		{
			$data								= supplier::find($id);
		}
		else
		{
			$data								= new supplier;
		}

		$data->fill([
			'name' 								=> $inputs['name'],
			'phone' 							=> $inputs['phone'],
			'address' 							=> $inputs['address'],
		]);

		DB::beginTransaction();
		if (!$data->save())
		{
			DB::rollback();
			return Redirect::back()
				->withInput()
				->withErrors($data->getError())
				->with('msg-type', 'danger');
		}	
		else
		{
			DB::commit();

			if(Input::get('id'))
			{
				$msg = "Data sudah diperbarui";
			}
			else
			{
				$msg = "Data sudah ditambahkan";
			}

			return Redirect::route('backend.supplier.index')
				->with('msg',$msg)
				->with('msg-type', 'success');
		}
	}

	public function destroy($id)
	{
		if (Input::get('password'))
		{		
			$data									= supplier::find($id);

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
				return Redirect::route('backend.supplier.index')
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
    public function getExpiredFromSetting($type)
    {
        $exp_date       = policy::GetExpired(['type' => $type, 'date' => 'now'])->first();
        
        if(empty($exp_date))
        {
            throw new Exception('Setting not found.');
        }

        return $exp_date;
    }


    public function checkIsExpired($exp_date, $transac_date)
    {
        if(date('Y-m-d H:i:s') >= date('Y-m-d H:i:s', strtotime($transac_date . $exp_date)) )
        {
            $result         = new jsend('success', (array)'Expired');        
        }
        else
        {
            $result         = new jsend('success', (array)'Live');        
        }
        return $result;
    }
}