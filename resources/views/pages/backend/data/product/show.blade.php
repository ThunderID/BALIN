@inject('data', 'App\Models\Product')
<?php $data = $data::where('id', $id)
									->with('categories')
									// ->with(['productattributes' => function($q){$q->orderBy('attribute', 'asc');}])
									->with('images')
									->first(); 

?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Produk
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="name">Nama</label>
				{!! Form::text('name', $data['name'], ['class' => 'form-control mod_name', 'required' => 'required', 'tabindex' => '1', 'readonly' => 'readonly'] ) !!}
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">		
			<label for="sku">SKU</label>
			{!! Form::text('sku', $data->sku, ['class' => 'form-control mod_name', 'required' => 'required', 'tabindex' => '1', 'readonly' => 'readonly'] ) !!}
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="">Kondisi</label>
				<input type="text" value="@if($data->is_new==1) Baru @else Bekas @endif" class="form-control" readonly />
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="">Stok</label>
				{!! Form::text('stock', $data->stock, ['class' => 'form-control', 'tabindex' => '1', 'readonly' => 'readonly'] ) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="">Deskripsi</label>
				{!! Form::textarea('description', $data->description, ['class' => 'form-control', 'rows' => '3', 'tabindex' => '1', 'style' => 'resize:none;', 'readonly' => 'readonly'] ) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="">Harga</label>
				{!! Form::text('price', $data->price, ['class' => 'form-control', 'tabindex' => '1', 'readonly' => 'readonly']) !!}
			</div>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="">Harga Promo</label>
				{!! Form::text('promo_price', $data->promo_price, ['class' => 'form-control', 'tabindex' => '1', 'readonly' => 'readonly'] ) !!}
			</div>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="">Diskon</label>
				{!! Form::text('discount', $data->discount, ['class' => 'form-control', 'tabindex' => '1', 'readonly' => 'readonly'] ) !!}
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Kategori
			</h4>
		</div>
	</div>
	@foreach ($data->categories as $cat)
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					{!! Form::text('categories', $cat->name, ['class' => 'form-control', 'tabindex' => '1', 'readonly' => 'readonly'] ) !!}
				</div>
			</div>
		</div>
	@endforeach

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Images
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 text-center">
			@foreach ($data->images as $k => $img)
				@if ($k==5)
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				@endif
				{!! HTML::image($img->image_xs) !!}
			@endforeach
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop