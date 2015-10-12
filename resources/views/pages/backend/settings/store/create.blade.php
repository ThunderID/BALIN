@inject('data', 'App\Models\StoreSetting')

@if ($id)
	<?php $data = $data::find($id); ?>
@endif

@extends('template.backend.layout') 

@section('content')
	{!! Form::open(array('route' => 'backend.settings.store.store')) !!}
		{!! Form::input('hidden', 'id', $data['id'], ['class' => 'mod_id']) !!}
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Type</label>
					{!! Form::text('type', $data->type, [
								'class'         => 'form-control', 
								'tabindex'      => '1'
					]) !!}
				</div>              
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="name" class="text-capitalize">URL</label>
					{!! Form::text('url', $data['name'], [
								'class'         => 'form-control', 
								'tabindex'      => '2'
					]) !!}
				</div> 
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="summernote"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.store.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-success" tabindex="4">Simpan</button>
				</div>
			</div>                                     
		</div>
	{!! Form::close() !!}
@stop

@section('script_plugin')
	@include('plugins.summernote')
@stop