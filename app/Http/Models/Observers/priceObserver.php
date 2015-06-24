<?php namespace Models\Observers;

use \Validator;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving		
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class PriceObserver 
{
	public function saving($model)
	{
		$validator 				= Validator::make($model['attributes'], $model['rules']);

		if ($validator->passes())
		{
			if($model['attributes']['price'] > 0 && $model['attributes']['promo_price'] > 0)
			{
				return true;
			}else{
				$model['errors'] 	= 'Harga harus lebih besar dari 0';

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
		if($model->Product->count())
		{
			$model['errors'] 	= ['Tidak dapat menghapus data harga'];

			return false;
		}

		return true;
	}

}