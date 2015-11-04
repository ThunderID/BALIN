@extends('template.backend.layout') 
@inject('datas', 'App\Models\StoreSetting')

<?php $datas = $datas::policies()->get(); ?>

@section('content')
	{!! Form::open(array('url' => route('backend.settings.policies.store'), 'method' => 'POST')) !!}
		<div class="row">
			@foreach($datas as $key => $value)
				{!! Form::hidden('id['.$key.']', $value['id']) !!}			
				<div class="col-md-6">
					<div class="form-group">
						<label for="parent" class="text-capitalize">{{str_replace('_', ' ', $value['type'])}}</label>
						{!! Form::text('value['.$key.']', $value['value'], [
									'class'			=> 'form-control', 
									'tabindex'		=> $key+1
						]) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="parent" class="text-capitalize">&nbsp;</label>
						{!! Form::hidden('type['.$key.']', $value['type'], [
									'class'			=> 'form-control'
						]) !!}
						<?php
							$date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value['started_at'])->format('d-m-Y H:i'); 
						?>
						{!! Form::text('start['.$key.']', $date, [
									'class'			=> 'date-time-format form-control' 
						]) !!}
					</div>
				</div>
			@endforeach
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.policies.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop

@section('script_plugin')
	@include('plugins.summernote')
@stop