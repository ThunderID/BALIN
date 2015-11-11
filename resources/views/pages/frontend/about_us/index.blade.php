@inject('about_us', 'App\Models\StoreSetting')
<?php
	$about_us = $about_us::where('type', 'about_us')->first();
?>
@extends('template.frontend.layout')
@section('content')    
	<div class="container mt-75">
		<div class="row">
			<div class="col-md-7 col-sm-7 col-xs-12">
				@include('widgets.breadcrumb')
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				{!! $about_us['value'] !!}
			</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop