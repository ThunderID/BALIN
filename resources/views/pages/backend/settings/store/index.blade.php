@inject('datas', 'App\Models\StoreSetting')

<?php $datas = $datas->type(['url', 'logo', 'facebook_url', 'twitter_url', 'email', 'phone', 'address', 'bank_information'])->get(); ?>

@extends('template.backend.layout') 

@section('content')
	{!! Form::open(array('route' => 'backend.settings.store.store')) !!}
		@foreach($datas as $key => $value)
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						@if(strtolower($value['type'])=='phone')
						<label for="parent" class="text-capitalize">{{str_replace('_', ' ', $value['type'])}}</label>
						{!! Form::text(strtolower($value['type']), $value['content'], [
									'class'			=> 'form-control', 
									'tabindex'		=> $key+1
						]) !!}
						@elseif(strtolower($value['type'])=='bank_information' || strtolower($value['type'])=='address')
						<label for="parent" class="text-capitalize">{{str_replace('_', ' ', $value['type'])}}</label>
						{!! Form::textarea(strtolower($value['type']), $value['content'], [
									'class'			=> 'form-control', 
									'tabindex'		=> $key+1
						]) !!}
						@else
						<label for="parent" class="text-capitalize">{{str_replace('_', ' ', $value['type'])}}</label>
						{!! Form::text(strtolower($value['type']), $value['url'], [
									'class'			=> 'form-control', 
									'tabindex'		=> $key+1
						]) !!}
						@endif
					</div>
				</div>
			</div>
		@endforeach
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<button type="submit" class="btn btn-md btn-primary" tabindex="9">Simpan</button>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop