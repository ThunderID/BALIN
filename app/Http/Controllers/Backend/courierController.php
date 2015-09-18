<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\baseController;
use Models\Courier;
use Models\courierBranches;
use Input, Session, DB, Redirect, App;

class courierController extends baseController 
{
	protected $view_name 						= 'Kurir';

	public function index()
	{	

		if(Input::get('q'))
		{
			$datas								= Courier::where('name','like', '%'.Input::get('q').'%')
													->paginate();
			$searchResult						= "Menampilkan data pencarian '" .Input::get('q')."'";
		}
		else
		{
			$datas								= Courier::paginate();
			$searchResult						= NULL;
		
		}

		$breadcrumb								= array(
													'Kurir' => 'backend.courier.index',
													 );
		$this->layout->page 					= view('pages.backend.menu-shipping.courier.index')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('datas', $datas)
													->with('searchResult', $searchResult)
													;

		return $this->layout;
	}


	public function detail()
	{
		$courier_id 							= Input::get('courier_id');
		$breadcrumb								= array(
													'Kurir' => 'backend.courier.index',
													'Detail' => 'backend.courier.detail',
													 );
		if(Input::get('q'))
		{
			$data_branches						= courierBranches::where('courier_id',$courier_id)
													->where('name','like', '%'.Input::get('q').'%')
													// ->where('address','like', Input::get('q'))
													->paginate();
			$searchResult						= "Menampilkan data pencarian '" .Input::get('q')."'";
		}
		else
		{
			$data_branches						= courierBranches::where('courier_id',$courier_id)->paginate();
			
			if(count($data_branches) < 1)
			{
				App::abort(404);
			}

			$searchResult						= NULL;
		}

		$data									= courier::where('id',$courier_id)->first();
		$this->layout->page 					= view('pages.backend.menu-shipping.courier.detail')
													->with('WT_pageTitle', $this->view_name )
													->with('WT_pageSubTitle','Index')
													->with('WB_breadcrumbs', $breadcrumb)
													->with('data_branches',$data_branches)
													->with('data',$data)
													->with('searchResult', $searchResult)
													;

		return $this->layout;
	}

	public function save()
	{
		print_r(Input::all());
		exit;
	}

	public function delete()
	{
		if(Input::get('id'))
		{
			$data							= courier::find(Input::get('id'));

			DB::beginTransaction();

			if(!$data->delete())
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
				return Redirect::route('backend.courier.index')
					->with('msg', 'Data telah dihapus')
					->with('msg-type','success')
					;
			}
		}
		else
		{
			return Redirect::back()
				->withInput()
				->with('msg', "Hapus data gagal. Tidak ada data yang dipilih")
				->with('msg-type','danger')
				;			
		}
	}

	public function upload_image($file)
	{		
		if ($file)
		{
			$validator = Validator::make(['file' => $file], ['file' => 'image|max:500']);
			if (!$validator->passes())
			{
				return Response::json(['message' => $validator->errors()->first()], 500);
			}
			// generate path 
			$path = '/images/' . date('Y/m/d/H') . '/'; 
			// generate filename
			$filename =  str_replace(' ', '-', $file->getClientOriginalName());
			$i = 1;
			while (file_exists(public_path() . '/' . $path . $filename))
			{
				$filename = $i . '-' . str_replace(' ', '-', $file->getClientOriginalName());
				$i++;
			}
			
			// move uploaded file to path
			$file->move(public_path() . '/' . $path,  str_replace(' ', '-', $filename));
			// create 
			$paths['sm'] = asset($this->copyAndResizeImage($path . $filename, 320, 180));
			$paths['md'] = asset($this->copyAndResizeImage($path . $filename, 640, 360));
			$paths['lg'] = asset($this->copyAndResizeImage($path . $filename, 960, 540));
			$paths['ori'] = asset($path .  $filename);			
		}
		return $paths;
	}
}