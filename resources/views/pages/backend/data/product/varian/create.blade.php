@inject('data', 'App\Models\Varian')
<?php 
	$data 			= $data::where('id', $id)->with('product')->first();
?>

@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.data.product.varian.update', ['pid' => $pid, 'id' => $id] ), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.data.product.varian.store', ['pid' => $pid] ), 'method' => 'POST', 'id' => 'my-awesome-dropzone', 'class' => 'dropzone']) !!}
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
					<label for="sku">SKU</label>
					{!! Form::text('sku', $data['sku'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan kode SKU',
								'tabindex'      => '1', 
					]) !!}
				</div>
			</div> 			
			<div class="col-md-6">
				<div class="form-group">
					<label for="size">Ukuran</label>
					{!! Form::text('size', $data['size'], [
								'class'         => 'form-control', 
								'tabindex'      => '2', 
								'placeholder'   => 'Masukkan ukuran produk'
					]) !!}
				</div>  
			</div> 
		</div>
	
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.data.product.show', ['id' => $pid]) }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
				</div>        
			</div>        
		</div>        
	{!! Form::close() !!}   
@stop


@section('script')
			 
@stop

@section('script_plugin')

@stop