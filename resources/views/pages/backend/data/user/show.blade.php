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
	@if($customer->is_active)
		<label class="label label-success">active</label>
	@else
		<label class="label label-danger">inactive</label>
	@endif
	<label class="label">{!!$customer->name!!}</label><br/>
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
					{!! $customer->balance !!}
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
					{!! $customer->quota !!}
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
					<h5><strong>Referral Code</strong><br/> {!!$customer->referral_code!!}</h5>
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

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop