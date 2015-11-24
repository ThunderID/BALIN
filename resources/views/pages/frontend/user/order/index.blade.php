@inject('transaction', 'App\Models\Transaction')
<?php
	$orders 		= $transaction->userid(Auth::user()->id)->type('sell')->status(['wait', 'paid', 'shipping', 'delivered', 'canceled'])->orderby('transact_at', 'desc')->with(['transactiondetails', 'pointlogs', 'transactionlogs'])->paginate();
?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Ref Numer</th>
							<th class="text-center">Tanggal</th>
							<th class="text-center">Status</th>
							<th class="text-center">Pembayaran</th>
							<th class="text-center">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php $number = (($orders->currentPage() - 1) * $orders->perPage()) + 1;?>
						@forelse($orders as $key => $value)
							<tr>
								<td class="text-center">{!!(($key)+$number)!!}</td>
								<td> {{$value['ref_number']}} </td>
								<td class="text-center m-l-xs"> @date_indo($value['transact_at']) </td>
								<td class="text-center"> {{$value['status']}} </td>
								<td class="text-right"> @money_indo($value['amount']) </td>
								<td class="text-center">  
									<a class="link-grey hover-black unstyle m-l-sm" href="#" data-toggle="modal" data-target=".submodal-user-information" data-action="{{ route('frontend.user.order.show', ['ref' => $value['ref_number']]) }}" data-modal-title="Detail Pesanan {{ $value['ref_number'] }}">Detail</a>

									@if($value['status']=='wait')
										&nbsp; | &nbsp;
										<a class="link-grey hover-red unstyle" href="#" data-toggle="modal" 
									    data-target=".submodal-user-information" data-action="{{ route('frontend.user.order.confirm') }}" data-action-parsing="{{ route('frontend.user.order.destroy', ['ref' => $value['ref_number']])  }}" data-modal-title="Pembatalan Pesanan">
									    	Batal
									    </a>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5"> Tidak ada data </td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			<div class="row">
                <div class="col-md-12 text-right hollow-pagination">
                    {!! $orders->appends(Input::all())->render() !!}
                </div>
            </div>
		</div>
	</div>