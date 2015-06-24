<?php namespace Models\Observers;

use \Validator;
use Models\Courier;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving		
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class shippingObserver 
{
	public function saving($model)
	{
		$validator 				= Validator::make($model['attributes'], $model['rules']);

		if ($validator->passes())
		{
			$courierId 			= $model['attributes']['courier_id'];

			$data 				= Courier::id($courierId)->first();

			if($data['status'] == 1)
			{
				return true;
			}else{
				$model['errors'] 	= 'Kurir tidak aktif';
				return false;
			}
		}
		else
		{
			$model['errors'] 	= $validator->errors();

			return false;
		}
	}

	public function deleting($model)
	{
		if($model->courier->count() && $model->Transaction->count())
		{
			$model['errors'] 	= ['Tidak dapat menghapus data shipping'];

			return false;
		}

		return true;
	}

}