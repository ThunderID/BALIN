@inject('data', 'App\Models\Price')
@inject('store', 'App\Models\StoreSetting')
<?php
	$margin				= $store->ondate('now')->type('min_margin')->first();
	$data				= $data::where('id', $id)->first();
	$date 				= null;
?>

@if($data)
	<?php 
		$date 			= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->started_at)->format('d-m-Y H:i'); 
	?>
@endif	

@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.data.product.price.update', ['pid' => $pid, 'id' => $id]), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.data.product.price.store', ['pid' => $pid]), 'method' => 'POST', 'id' => 'my-awesome-dropzone', 'class' => 'dropzone']) !!}
	@endif
		<div class="row">
			<div class="col-md-2">
				HPP (Weighted Average)<br/>
				Minimum Margin
			</div>
			<div class="col-md-2 text-right">
				<strong>@money_indo($product['hpp'])</strong><br/>
				<strong>@money_indo($margin['value'])</strong>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="price" class="text-capitalize">Harga</label>
					{!! Form::text('price', $data['price'], [
								'class'         => 'form-control money', 
								'tabindex'      => '2',
								'placeholder'   => 'Harga'
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="price" class="text-capitalize">Harga Promo</label>
					{!! Form::text('promo_price', $data['promo_price'], [
								'class'         => 'form-control money', 
								'tabindex'      => '2',
								'placeholder'   => 'Harga promo (setelah di diskon). Kosongkan bila tidak ada diskon'
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="start_at">Mulai</label>
					{!! Form::text('start_at', $date, [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '9', 
								'placeholder'   => 'dd-mm-yyyy hh:mm'
					]) !!}
				</div>
			</div>
			<div class="col-md-6">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">             
				</br>
				<div class="form-group text-right">
					<a href="{{ route('backend.data.product.price.index', ['pid' => $pid]) }}" class="btn btn-md btn-default" tabindex="4">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="5">Simpan</button>
				</div>
			</div>                                          
		</div>
	{!! Form::close() !!}
@stop

@section('script_plugin')
	@include('plugins.input-mask')
@stop