@inject('datas', 'App\Models\transactiondetail')
<?php
// $datas 			= DB::table('transaction_details')
$datas 			= $datas
				    // ->select( array('transaction_details.*', 'transactions.*') )
				    // ->leftJoin('transactions', 'transactions.id', '=', 'transaction_details.id')
				    // ->paginate()
					// ->select()
					->with(['transaction' => function ($query) use ($start, $end) {
					                $query->RangeDate($start, $end);
					            }])
					// ->with('transaction')
					->selectRaw('sum(transaction_details.quantity) as qty from transaction_details')
				    ->groupBy('transaction_details.product_id')
				    ->orderBy('qty', 'DESC')
					// ->where('transacted_at', '>=', date('Y-m-d H:i:s', strtotime('now')))
					// ->raw('SELECT product_id, sum(quantity) as qty from transaction_details group by product_id order by qty')
					// ->paginate()
					->get()
					;
dd($datas);
?>

