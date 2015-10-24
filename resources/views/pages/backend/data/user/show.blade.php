@inject('user', 'App\Models\User')
@inject('transaction', 'App\Models\Transaction')
@inject('td', 'App\Models\TransactionDetail')
@inject('payment', 'App\Models\Payment')
<?php 
	$data 			= $user::id($id)
						->with(['images'])
						->first(); 
	$transaction 	= $transaction->userid($id)->status(['paid', 'delivered', 'shipped'])->type('sell')->count();
	$payment 		= $payment->userid($id)->sum('amount');
	$mostbuy		= $td->mostbuybycustomer($id)->with(['product'])->get();
	$frequentbuy	= $td->frequentbuybycustomer($id)->with(['product'])->get();
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Kostumer
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					@forelse ($data->images as $k => $img)
						@if ($k==5)
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						@endif
						{!! HTML::image($img->image_xs) !!}
					@empty
					@endforelse
				</div>
			</div>
		</div>

		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading">Balance</div>
				<div class="panel-body">
					{!! $data->balance !!}
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading">Total Transaksi</div>
				<div class="panel-body">
					{!! $transaction !!}
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading">Total Belanja</div>
				<div class="panel-body">
					{!! $payment !!}
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading">Rerata Belanja</div>
				<div class="panel-body">
					@if(!is_null($payment) && !is_null($transaction) && $transaction!=0)
						{!! $payment/$transaction !!}
					@else
						0
					@endif
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<h2 style="margin-top:0px;">
				{!!$data->name!!}
				@if($data->is_active)
					<label class="label label-success">active</label><br/>
				@else
					<label class="label label-danger">inactive</label><br/>
				@endif
			</h2>

			<h5><strong>Referral Code</strong> {!!$data->referral_code!!}</h5>
			<h5><strong>Tanggal Join</strong> @date_indo($data->joined_at)</h5>
			<h5><strong>Gender</strong> {!!$data->gender!!}</h5>
			<h5><strong>Tanggal Lahir</strong> @date_indo($data->date_of_birth)</h5>
			<h5><strong>Nomor Telepon</strong> {!!$data->phone!!}</h5>
			<h5><strong>Email</strong> {!!$data->phone!!}</h5>
			<h5><strong>Kode Pos</strong> {!!$data->postal_code!!}</h5>
			<h5><strong>Alamat</strong> {!!$data->address!!}</h5>
			
			<br/>
			
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">Daftar Barang banyak dibeli</div>
				<div class="panel-body">
					@if(!is_null($mostbuy))
						<ul>
						@foreach($mostbuy as $key => $value)
							<li>
								{!! $value->product->name !!}
								<strong>{!! $value->total_buy !!}</strong>
							</li>
						@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">Daftar Barang sering dibeli</div>
				<div class="panel-body">
					@if(!is_null($frequentbuy))
						<ul>
						@foreach($frequentbuy as $key => $value)
							<li>
								{!! $value->product->name !!}
								<strong>{!! $value->frequent_buy !!}</strong>
							</li>
						@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop