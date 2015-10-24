@inject('data', 'App\Models\Price')
<?php
	$data	= $data::where('id', $id)
					->first();
?>

@extends('template.backend.layout') 

@section('content')
	{!! Form::open(['route' => 'backend.data.product.price.store']) !!}
		<div class="row">
			<div class="col-md-6">
				{!! Form::hidden('product_id', $product_id) !!}
				<div class="form-group">
					<label for="price" class="text-capitalize">Harga</label>
					{!! Form::text('price', $data['price'], [
								'class'         => 'form-control', 
								'tabindex'      => '2',
								'placeholder'   => 'Masukkan harga'
					]) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="price" class="text-capitalize">Harga Promo</label>
					{!! Form::text('promo_price', $data['promo_price'], [
								'class'         => 'form-control', 
								'tabindex'      => '2',
								'placeholder'   => 'Masukkan harga promo'
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="start_date" class="text-capitalize">Tanggal Mulai</label>
					{!! Form::input('datetime-local','started_at', $data['started_at'], [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'   => 'Tanggal berlaku harga'
					]) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="label" class="text-capitalize">Label</label>
					{!! Form::text('label', $data['label'], [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'   => 'Masukkan label'
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">             
				</br>
				<div class="form-group text-right">
					<a href="{{ route('backend.data.product.price.index', ['product_id' => $product_id]) }}" class="btn btn-md btn-default" tabindex="4">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="5">Simpan</button>
				</div>
			</div>                                          
		</div>
	{!! Form::close() !!}
@stop

@section('script')
@stop