@inject('data', 'App\Models\Product')
<?php 
	$data 			= $data::where('id', $id)->with('categories')->first();
	$date 			= null;
	$price	 		= null;
	$promo_price 	= null;
?>

@if($data)
	<?php 
		$date 			= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->startedAt)->format('d-m-Y H:i'); 
		$price 			= $data->price;
		$promo_price	= $data->promoprice;
	?>
@endif	

@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.data.product.update', ['uid' => $uid, 'id' => $id] ), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.data.product.store', ['uid' => $uid] ), 'method' => 'POST', 'id' => 'my-awesome-dropzone', 'class' => 'dropzone']) !!}
	@endif
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Varian
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="name">Nama Varian Produk</label>
					{!! Form::text('name', $data['name'], [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan nama varian produk'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="sku">SKU</label>
					{!! Form::text('sku', $data['sku'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan kode SKU',
								'tabindex'      => '2', 
					]) !!}
				</div>
			</div>                                         
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="color">Warna</label>
					{!! Form::text('color', $data['color'], [
								'class'         => 'form-control', 
								'tabindex'      => '3', 
								'placeholder'   => 'Masukkan warna'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="size">Ukuran</label>
					{!! Form::text('size', $data['size'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan ukuran',
								'tabindex'      => '4', 
					]) !!}
				</div>
			</div>                                         
		</div>		
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="description">Deskripsi Produk</label>
					{!! Form::textarea('description', $data['description'], [
								'class'         => 'summernote form-control', 
								'placeholder'   => 'Masukkan deskripsi',
								'rows'          => '2',
								'tabindex'      => '5',
								'style'         => 'resize:none;',
					]) !!}
				</div>            
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Kategori
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="category">Kategori</label>
					{!! Form::text('category', null, [
								'class'         => 'select-category', 
								'tabindex'      => '6',
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
					Harga
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Harga</label>
					{!! Form::text('price', $price, [
								'class'        		=> 'form-control money', 
								'tabindex'     		=> '7', 
								'placeholder'  		=> 'harga',
					]) !!}
				</div>  
			</div>  
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Harga Promo</label>
					{!! Form::text('promo_price', $promo_price, [
								'class'         => 'form-control money', 
								'tabindex'      => '8', 
								'placeholder'   => 'harga promo (kosongkan bila tidak ada harga promo)'
					]) !!}
				</div>  
			</div> 		
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Mulai</label>
					{!! Form::text('started_at', $date, [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '9', 
								'placeholder'   => 'Y-m-d H:i:s'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Label</label>
					{!! Form::text('label', $data['label'], [
								'class'         => 'form-control', 
								'tabindex'      => '10', 
								'placeholder'   => 'Label'
					]) !!}
				</div>  
			</div> 
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Gambar
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label for="">Thumbnail</label><br>
						{!! HTML::image('http://placehold.it/180x180/bababa/000000/?text=gambar', null, ['style' => 'background-color:#eee;padding:10px']) !!}
					<input type="file" style="opacity:0" class="file-upload">
					<a class="btn btn-sm btn-primary btn-file-upload m-t-n-md">Upload Thumbnail</a>
				</div>
			</div>
			<div class="col-md-8">
				<div class="form-group">
					<label for="">Galeri</label>
					<div class="gallery" style="width:100%;height:200px;background-color:#eee;padding:10px">
						{!! HTML::image('http://placehold.it/180x180/bababa/000000/?text=gambar') !!}
					</div>
					<input type="file" name="gallery[]" class="gallery-upload hide" data-url="{{ route('backend.data.product.store') }}"><br>
					<a class="btn btn-sm btn-primary btn-gallery-upload m-t-n-md">Upload Galeri</a>
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.data.productuniversal.show', ['uid' => $uid]) }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
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
	@include('plugins.input-mask')
@stop