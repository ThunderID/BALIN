@inject('transaction', 'App\Models\Transaction')
<?php
	$orders 		= $transaction->userid(Auth::user()->id)->type('sell')->orderby('transact_at', 'desc')->paginate();
?>
@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-sm-12">
			<h3 class="page-title m-t-lg">{{$title}}</h3>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>#</th>
						<th>Tanggal</th>
						<th>Status</th>
						<th>Pembayaran</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					@forelse($orders as $key => $value)
						<tr>
							<td>{!!(($key)+1)!!}</td>
							<td> {{$value['ref_number']}} </td>
							<td> @date_indo($value['transact_at']) </td>
							<td> {{$value['status']}} </td>
							<td> @money_indo($value['amount']) </td>
							<td>  <a href="{{ route('frontend.profile.order.show', $value['ref_number']) }}">Detail</a></td>
						</tr>
					@empty
						<tr>
							<td colspan="5"> Tidak ada data </td>
						</tr>
					@endforelse
				</tbody>
			</table>
			<div class="row">
                <div class="col-md-12" style="text-align:right;">
                    {!! $orders->appends(Input::all())->render() !!}
                </div>
            </div>
		</div>
	</div>
@stop