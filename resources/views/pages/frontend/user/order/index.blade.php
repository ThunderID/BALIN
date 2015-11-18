@inject('transaction', 'App\Models\Transaction')
<?php
	$orders 		= $transaction->userid(Auth::user()->id)->type('sell')->status(['wait', 'paid', 'shipping', 'delivered', 'canceled'])->orderby('transact_at', 'desc')->with(['transactiondetails', 'pointlogs', 'transactionlogs'])->paginate();
?>
@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-sm-12">
			<h3 class="page-title m-t-0">{{$title}}</h3>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">#</th>
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
								<td> @date_indo($value['transact_at']) </td>
								<td> {{$value['status']}} </td>
								<td class="text-right"> @money_indo($value['amount']) </td>
								<td>  
									<a class="link-grey hover-black unstyle" href="{{ route('frontend.profile.order.show', $value['ref_number']) }}">Detail</a>
									@if($value['status']=='wait')
									, <a class="link-grey hover-black unstyle" href="{{ route('frontend.profile.order.destroy', $value['ref_number']) }}">Batal</a>
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
@stop