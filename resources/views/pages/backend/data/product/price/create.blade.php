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
		<?php
			$date = Null;
			$time = Null;
			if (isset($data['started_at']))
			{
				$date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['started_at'])->format('Y-m-d');
				$time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['started_at'])->format('H:i');
			}
		?>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="start_date" class="text-capitalize">Tanggal Mulai</label>
					{!! Form::input('date','date', $date, [
								'class'         		=> 'form-control input-date', 
								'tabindex'      		=> '3',
								'placeholder'   		=> 'Tanggal berlaku harga',
								'data-date'		 		=> '',
								'data-date-format'	=> 'DD-MM-YYYY',
					]) !!}
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					{!! Form::input('time','time', $time, [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'   => 'Time berlaku harga',
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