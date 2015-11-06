@inject('data', 'App\Models\ProductUniversal')
<?php 
		$data = $data::find($id); 
?>
@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.data.productuniversal.update', $id), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.data.productuniversal.store'), 'method' => 'POST', 'id' => 'my-awesome-dropzone', 'class' => 'dropzone']) !!}
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
					<label for="upc">UPC Produk</label>
					{!! Form::text('upc', $data['upc'], [
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
					<label for="description">Deskripsi Produk</label>
					{!! Form::textarea('description', $data['description'], [
								'class'         => 'summernote form-control', 
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
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.data.productuniversal.index') }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="9">Simpan</button>
				</div>        
			</div>        
		</div>        
	{!! Form::close() !!}   
@stop

@section('script_plugin')
	@include('plugins.summernote')
@stop