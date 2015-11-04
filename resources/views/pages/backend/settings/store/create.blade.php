@extends('template.backend.layout') 

@section('content')
	{!! Form::open(array('url' => route('backend.settings.store.update', $id), 'method' => 'PATCH')) !!}
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					{!! Form::textarea('content', $page['value'], [
								'class' 				=> 'summernote',
								'style'         		=> 'resize:none;',
					]) !!}
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.store.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('script_plugin')
	@include('plugins.summernote')
@stop