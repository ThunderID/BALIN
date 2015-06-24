<?php namespace Models\Observers;

use \Validator;
use Models\Customer;
use Models\Credit_log;

/* ----------------------------------------------------------------------
 * Event:
 * 	Saving		
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class Credit_logObserver 
{
	public function saving($model)
	{
		$validator 				= Validator::make($model['attributes'], $model['rules']);

		if ($validator->passes())
		{
			$coupon_code 		= $model['attributes']['coupon_code'];

			$Customer 			= Customer::couponCode($coupon_code)->first();

			$debet 				= 0;
			$datas 				= Credit_log::debet($coupon_code)->get();
			foreach ($datas as $data) {
				$debet 			= $debet + $data['debet'];
			}

			$credit 			= 0;
			$datas 				= Credit_log::credit($coupon_code)->get();
			foreach ($datas as $data) {
				$credit 		= $credit + $data['credit'];
			}			

			$balance 			= $credit - $debet;

			$Customer->fill(['coupon_balance' => $balance]);
			if($Customer->save())
			{
				return true;
			} 
			else
			{
				$model['errors'] = $Customer->getError();
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
		if($model->Customer->count())
		{
			$model['errors'] 	= ['Tidak dapat menghapus data credit'];

			return false;
		}

		return true;
	}

}