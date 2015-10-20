@inject('data', 'App\Models\Courier')

@if ($id)
	<?php $data = $data::find($id); ?>
@endif

@extends('template.backend.layout') 

@section('content')
	{!! Form::open(array('route' => 'backend.settings.courier.store')) !!}
		{!! Form::input('hidden', 'id', $data['id'], ['class' => 'mod_id']) !!}
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="form-group">
					{!! HTML::image('http://placehold.it/200x200/bababa/000000/?text=gambar') !!}
					<input type="file" style="opacity:0" class="file-image">
					<a href="#" class="btn btn-primary btn-upload">Upload Gambar</a>
				</div>
			</div>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Nama</label>
					{!! Form::text('name', $data->name, [
								'class'         => 'form-control', 
								'tabindex'      => '1'
					]) !!}
				</div>              
				<div class="form-group">
					<label for="name" class="text-capitalize">Alamat</label>
					{!! Form::textarea('address', $data->address, [
								'class'         => 'form-control', 
								'required'      => 'required', 
								'rows'          => '3',
								'tabindex'      => '3',
								'style'         => 'resize:none;',
						]) 
					!!}
				</div> 
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.courier.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-success" tabindex="4">Simpan</button>
				</div>
			</div>                                     
		</div>
	{!! Form::close() !!}
@stop

@section('script')
	$( document ).ready(function() {
		$('.btn-upload').on('click', function() {
			$('.file-image').trigger('click');
		});
	});
@stop