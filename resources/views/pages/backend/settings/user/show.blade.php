@inject('user', 'App\Models\User')
@inject('transaction', 'App\Models\Transaction')
@inject('td', 'App\Models\TransactionDetail')
@inject('payment', 'App\Models\Payment')
<?php 
	$transaction 	= $transaction->userid($id)->status(['paid', 'delivered', 'shipped'])->type('sell')->count();
	$payment 		= $payment->transactionuserid($id)->sum('amount');
	$mostbuy		= $td->mostbuybycustomer($id)->with(['product'])->get();
	$frequentbuy	= $td->frequentbuybycustomer($id)->with(['product'])->get();
?>

@extends('template.backend.layout') 

@section('content')
	<label class="label">{!!$authentication->name!!}</label>
	@if($authentication->is_active)
		<label class="label label-success">active</label>
	@else
		<label class="label label-danger">inactive</label>
	@endif
	<label class="label label-info">{!!str_replace('_', ' ', $authentication->role)!!}</label>
	<br/>
	<div class="row">
		<div class="col-md-3">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					{!! HTML::image($authentication->avatar, 'avatar', ['class' => 'img img-responsive']) !!}
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					@money_indo($authentication->balance)
				</div>
				<div class="panel-heading">Point</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					{!! $authentication->quota !!}
				</div>
				<div class="panel-heading">Quota</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					{!! $authentication->downline !!}
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
					<h5><strong>Nama</strong><br/> {!!$authentication->name!!}</h5>
					<h5><strong>Referral Code</strong><br/> {!!$authentication->referral_code!!} @if($authentication->voucher()->count()) <a href="{{route('backend.settings.voucher.edit', $authentication->voucher->id)}}"> custom royalti</a> @endif</h5>
					<h5><strong>Email</strong><br/> {!!$authentication->email!!}</h5>
					<h5><strong>Tanggal Join</strong><br/> @date_indo($authentication->created_at)</h5>
					<h5><strong>Gender</strong><br/> {!!$authentication->gender!!}</h5>
					<h5><strong>Tanggal Lahir</strong><br/> @date_indo($authentication->date_of_birth)</h5>
					<h5><strong>Nomor Telepon</strong><br/> {!!$authentication->phone!!}</h5>
					<h5><strong>Kode Pos</strong><br/> {!!$authentication->postal_code!!}</h5>
					<h5><strong>Alamat</strong><br/> {!!$authentication->address!!}</h5>
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
								{!! $value->product->name !!}
								<strong>{!! $value->total_buy !!}</strong>
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
								{!! $value->product->name !!}
								<strong>{!! $value->frequent_buy !!}</strong>
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
				<div class="panel-heading">Buku Tabungan</div>
				<div class="panel-body">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Debit</th>
								<th>Kredit</th>
								<th>Saldo</th>
								<th>Catatan</th>
							</tr>
						</thead>
						<tbody>
							<?php $amount = 0;?>
							@forelse($authentication->pointlogs as $key => $value)
								<?php $amount = $amount + $value->amount;?>
								<tr>
									<td>{!!($key+1)!!}</td>
									<td> @date_indo($value->created_at) </td>
									@if($value->amount >= 0)
										<td>@money_indo($value->amount)</td>
									@else
										<td></td>
									@endif
									@if($value->amount < 0)
										<td>@money_indo($value->amount)</td>
									@else
										<td></td>
									@endif
									<td>@money_indo($amount)</td>
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
			</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop