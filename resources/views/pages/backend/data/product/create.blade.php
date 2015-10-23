@inject('data', 'App\Models\Product')
<?php 
		$data = $data::where('id', $id)
							->with('categories')
							->first(); 
?>
@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.data.product.update', $id), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.data.product.store'), 'method' => 'POST', 'id' => 'my-awesome-dropzone', 'class' => 'dropzone']) !!}
	@endif
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Produk
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="name">Nama Produk</label>
					{!! Form::text('name', $data['name'], [
								'class'         => 'form-control', 
								
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan nama produk'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="sku">SKU Produk</label>
					{!! Form::text('sku', $data['sku'], [
								'class'         => 'form-control', 
								
								'placeholder'   => 'Masukkan kode SKU produk',
								'tabindex'      => '2', 
					]) !!}
				</div>
			</div>                                         
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="">Jenis</label>
					{!! Form::select('is_new', ['0' => 'Biasa', '1' => 'Baru'], null, ['class' => 'form-control']) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="description">Deskripsi Produk</label>
					{!! Form::textarea('description', $data['description'], [
								'class'         => 'summernote', 
								
								'placeholder'   => 'Masukkan deskripsi produk',
								'rows'          => '2',
								'tabindex'      => '3',
								'style'         => 'resize:none;',
					]) !!}
				</div>            
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Kategori Produk
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="category">Kategori</label>
					{!! Form::text('category', null, [
								'class'         => 'select-category', 
								'tabindex'      => '4',
								'id'            => 'find_category',
								'style'         => 'width:100%',
					]) !!}
				</div>  
			</div> 
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Harga Produk
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Harga</label>
					{!! Form::text('price', $data['price'], [
								'class'         => 'form-control', 
								
								'tabindex'      => '5', 
								'placeholder'   => 'harga'
					]) !!}
				</div>  
			</div>  
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Harga Promo</label>
					{!! Form::text('promo_price', $data['promo_price'], [
								'class'         => 'form-control', 
								
								'tabindex'      => '6', 
								'placeholder'   => 'harga promo (kosongkan bila tidak ada harga promo)'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Mulai</label>
					{!! Form::text('started_at', $data['started_at'], [
								'class'         => 'form-control', 
								
								'tabindex'      => '7', 
								'placeholder'   => 'Y-m-d H:i:s'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Label</label>
					{!! Form::text('label', $data['label'], [
								'class'         => 'form-control', 
								'tabindex'      => '8', 
								'placeholder'   => 'Label'
					]) !!}
				</div>  
			</div> 
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Gambar Produk
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label for="">Thumbnail</label><br>
						{!! HTML::image('http://placehold.it/180x180/bababa/000000/?text=gambar', null, ['style' => 'background-color:#eee;padding:10px']) !!}
					<input type="file" style="opacity:0" class="file-image">
					<a href="#" class="btn btn-primary btn-upload">Upload Gambar</a>
				</div>
			</div>
			<div class="col-md-8">
				<div class="form-group">
					<label for="">Gallery</label>
					<div class="gallery" style="width:100%;height:200px;background-color:#eee;padding:10px">
						{!! HTML::image('http://placehold.it/180x180/bababa/000000/?text=gambar') !!}
					</div>
					<input type="file" name="gallery[]" class="gallery-upload hide" data-url="{{ route('backend.data.product.store') }}"><br>
					<a href="#" class="btn btn-primary btn-upload">Upload Gambar</a>
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.data.product.index') }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="9">Simpan</button>
				</div>        
			</div>        
		</div>        
	{!! Form::close() !!}   
@stop


@section('script')
	$( document ).ready(function() {
		var tmplt      =   $("#attributeTemplate").html();

		$("#items").append(tmplt);
	});


	$("#add").click(function (e) {
		var tmplt      =   $("#attributeTemplate").html();

		$("#items").append(tmplt);
	});

	$("body").on("click", ".delete", function (e) {
		$(this).parent("div").parent("div").remove();
	});    

	var preload_data = [];

	selections = [
		@if ($data['categories'])
			@foreach($data['categories'] as $category)
				{ 
					id:{{$category['id']}},
					text:'{{$category['name']}}'
				},
			@endforeach
		@endif
	];

	for (i = 0; i < selections.length; i++) { 
		preload_data.push(selections[i]);         
	}

			 
@stop

@section('script_plugin')
	@include('plugins.select2')
	@include('plugins.summernote')
	@include('plugins.jquery-upload')
@stop