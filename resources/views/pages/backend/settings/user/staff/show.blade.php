@inject('auditor', 'App\Models\Auditor')
<?php 
$auditors              	= $auditor->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])/*->type(['transaction_canceled', 'transaction_paid', 'transaction_shipping', 'transaction_delivered'])*/->userid($authentication->id)->with(['user'])->get();
$cancel              	= $auditor->type('transaction_canceled')->userid($authentication->id)->count();
$paid              		= $auditor->type('transaction_paid')->userid($authentication->id)->count();
$shipping              	= $auditor->type(['transaction_shipping', 'transaction_delivered'])->userid($authentication->id)->count();
// $deliver              	= $auditor->type(['transaction_delivered'])->userid($authentication->id)->count();
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
		<div class="col-sm-6 col-md-3">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-sm-12 col-xs-12 text-center">
					{!! HTML::image($authentication->avatar, 'avatar', ['class' => 'img img-responsive']) !!}
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">Informasi Pribadi</div>
						<div class="panel-body m-l">
							<h5><strong>Nama</strong><br/> {!!$authentication->name!!}</h5>
							<h5><strong>Referral Code</strong><br/> {!!$authentication->referral_code!!}</h5>
							<h5><strong>Email</strong><br/> {!!$authentication->email!!}</h5>
							<h5><strong>Gender</strong><br/> {!!$authentication->gender!!}</h5>
							<h5><strong>Tanggal Lahir</strong><br/> @date_indo($authentication->date_of_birth)</h5>
							<h5><strong>Nomor Telepon</strong><br/> {!!$authentication->phone!!}</h5>
							<h5><strong>Kode Pos</strong><br/> {!!$authentication->postal_code!!}</h5>
							<h5><strong>Alamat</strong><br/> {!!$authentication->address!!}</h5>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					{!! $cancel !!}
				</div>
				<div class="panel-heading">Membatalkan Transaksi</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					{!! $paid !!}
				</div>
				<div class="panel-heading">Menangani Pembayaran</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-3">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					{!! $shipping !!}
				</div>
				<div class="panel-heading">Tracking Pengiriman</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-9">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Aktivitas Terakhir</div>
				<div class="panel-body">
					@if(!is_null($auditors))
						<ul>
						@forelse($auditors as $key => $value)
							<li>
								{!! $value['event'] !!}
							</li>
						@empty
							<p class="m-l"> Tidak ada aktivitas terakhir </p>
						@endforelse
						</ul>
					@endif
				</div>
			</div>
		</div>
	</div>
	</div>
	
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop