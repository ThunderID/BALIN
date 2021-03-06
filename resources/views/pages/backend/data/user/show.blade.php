@inject('user', 'App\Models\User')
@inject('transaction', 'App\Models\Transaction')
@inject('td', 'App\Models\TransactionDetail')
@inject('payment', 'App\Models\Payment')
@inject('point', 'App\Models\PointLog')
<?php 
	$transaction 	= $transaction->userid($id)->status(['paid', 'packed', 'shipping', 'delivered'])->type('sell')->count();
	$payment 		= $payment->transactionuserid($id)->sum('amount');
	$mostbuy		= $td->mostbuybycustomer($id)->with(['product'])->get();
	$frequentbuy	= $td->frequentbuybycustomer($id)->with(['product'])->get();
	$pointlogs		= $point->userid($id)->orderby('created_at', 'asc')->paginate();
?>

@extends('template.backend.layout') 

@section('content')
	<label class="label">{!!$customer->name!!}</label>
	@if($customer->is_active)
		<label class="label label-success">active</label>
	@else
		<label class="label label-danger">inactive</label>
	@endif
	<br/>
	<div class="row">
		<div class="col-md-3">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					{!! HTML::image($customer->avatar, 'avatar', ['class' => 'img img-responsive']) !!}
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					@money_indo($customer->balance)
				</div>
				<div class="panel-heading">Point</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					{!! $customer->quota !!}
				</div>
				<div class="panel-heading">Quota</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					{!! $customer->downline !!}
				</div>
				<div class="panel-heading">Downline</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					{!! $transaction !!}
				</div>
				<div class="panel-heading">Total Transaksi</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					@money_indo($payment)
				</div>
				<div class="panel-heading">Total Belanja</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					@if(!is_null($payment) && !is_null($transaction) && $transaction!=0)
						@money_indo($payment/$transaction)
					@else
						0
					@endif
				</div>
				<div class="panel-heading">Rerata Belanja</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Informasi Pribadi</div>
				<div class="panel-body m-l">
					<h5><strong>Nama</strong><br/> {!!$customer->name!!}</h5>
					<h5><strong>Referral Code</strong><br/> {!!$customer->referral_code!!} @if($customer->voucher()->count()) <a href="{{route('backend.settings.voucher.edit', $customer->voucher->id)}}"> custom royalti</a> @endif</h5>
					<h5><strong>Email</strong><br/> {!!$customer->email!!}</h5>
					<h5><strong>Tanggal Join</strong><br/> @date_indo($customer->created_at)</h5>
					<h5><strong>Gender</strong><br/> {!!$customer->gender!!}</h5>
					<h5><strong>Tanggal Lahir</strong><br/> @date_indo($customer->date_of_birth)</h5>
					<h5><strong>Nomor Telepon</strong><br/> {!!$customer->phone!!}</h5>
					<h5><strong>Kode Pos</strong><br/> {!!$customer->postal_code!!}</h5>
					<h5><strong>Alamat</strong><br/> {!!$customer->address!!}</h5>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Daftar Barang banyak dibeli</div>
				<div class="panel-body">
					@if(!is_null($mostbuy))
						<ul>
						@forelse($mostbuy as $key => $value)
							<li>
								{!! $value['varian']['product']['name'] !!} 
								<strong>{!! $value['total_buy'] !!}</strong>
							</li>
						@empty
							<p class="m-l"> Tidak ada riwayat belanja </p>
						@endforelse
						</ul>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Daftar Barang sering dibeli</div>
				<div class="panel-body">
					@if(!is_null($frequentbuy))
						<ul>
						@forelse($frequentbuy as $key => $value)
							<li>
								{!! $value['varian']['product']['name'] !!} 
								<strong>{!! $value['frequent_buy'] !!}</strong>
							</li>
						@empty
							<p class="m-l"> Tidak ada riwayat belanja </p>
						@endforelse
						</ul>
					@endif
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-list">
				<div class="panel-heading">
					Point {{$user['name']}}<small><a href="{{route('backend.data.pointlog.create', $customer['id'])}}">Tambah Point</a></small>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Debit</th>
								<th class="text-center">Kredit</th>
								<th class="text-center">Saldo</th>
								<th class="text-center">Catatan</th>
							</tr>
						</thead>
						<tbody>
							<?php $amount = 0;?>
							@forelse($pointlogs as $key => $value)
								<?php $amount = $amount + $value->amount;?>
								<tr>
									<td class="text-center">{!!($key+1)!!}</td>
									<td> @datetime_indo($value->created_at) </td>
									@if($value->amount >= 0)
										<td class="text-right">@money_indo(abs($value->amount))</td>
									@else
										<td></td>
									@endif
									@if($value->amount < 0)
										<td class="text-right">@money_indo(abs($value->amount))</td>
									@else
										<td></td>
									@endif
									<td class="text-right">@money_indo($amount)</td>
									<td>{!!$value->notes!!}</td>
								</tr>
							@empty
								<tr>
									<td colspan="6"> Tidak ada data </td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				@if(count($pointlogs) > 0)
					<div class="row">
						<div class="col-md-12" style="text-align:right;">
							{!! $pointlogs->appends(Input::all())->render() !!}
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop