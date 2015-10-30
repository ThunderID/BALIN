@inject('data', 'App\Models\Price')
<?php
	$data	= $data::where('id', $id)
					->first();
?>

@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.data.product.price.update', $id), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.data.product.price.store'), 'method' => 'POST', 'id' => 'my-awesome-dropzone', 'class' => 'dropzone']) !!}
	@endif
		<div class="row">
			<div class="col-md-6">
				{!! Form::hidden('product_id', $product_id) !!}
				<div class="form-group">
					<label for="price" class="text-capitalize">Harga</label>
					{!! Form::text('price', $data['price'], [
								'class'         => 'form-control money', 
								'tabindex'      => '2',
								'placeholder'   => 'Harga'
					]) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="price" class="text-capitalize">Harga Promo</label>
					{!! Form::text('promo_price', $data['promo_price'], [
								'class'         => 'form-control money', 
								'tabindex'      => '2',
								'placeholder'   => 'Harga promo (setelah di diskon). Kosongkan bila tidak ada diskon'
					]) !!}
				</div>
			</div>
		</div>
		<?php
			$date = Null;
			$time = Null;
			if (isset($data['started_at']))
			{
				$date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['started_at'])->format('d-m-Y');
				$time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['started_at'])->format('H:i');
			}
		?>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="start_date" class="text-capitalize">Mulai</label>
					{!! Form::input('date','date', $date, [
								'class'         		=> 'form-control input-date', 
								'tabindex'      		=> '3',
								'placeholder'   		=> 'dd-mm-yyyy',
								'data-date'		 		=> '',
								'data-date-format'		=> 'dd-mm-yyyy',
					]) !!}
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					{!! Form::input('time','time', $time, [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'   => 'hh:ii',
								'style'			 => 'margin-top:23px'
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

@section('script_plugin')
	@include('plugins.input-mask')
@stop