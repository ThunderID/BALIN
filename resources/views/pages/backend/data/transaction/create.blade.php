
@extends('template.backend.layout') 
@section('content')
	<div class="row">
		<div class="col-md-12">
			{!! Form::open(['route' => array('backend.data.transaction.store', 'type' => Input::get('type')), 'class' =>'wizard-big', 'id' => 'create-transaction']) !!}
				@if ($subnav_active=='sell')
					@include('pages.backend.data.transaction.sell.create')
				@else
					@include('pages.backend.data.transaction.buy.create')
				@endif
			{!! Form::close() !!}
		</div>
	</div>
@stop   

@section('script')
	var preload_data = [];

	$(document).ready(function() {
		$('input:radio[name=address_choice]').change(function() {
			var value = $(this).val();

			if (value=='0')
			{
				$('.label-phone').text($('.transaction-input-phone').val());
				$('.label-address').text($('.transaction-input-address').val());
				$('.label-postal-code').text($('.transaction-input-postal-code').val());
			}
			else
			{
				$('.label-phone').text($('.transaction-input-phone-new').val());
				$('.label-address').text($('.transaction-input-address-new').val());
				$('.label-postal-code').text($('.transaction-input-postal-code-new').val());
			}
		});
	});
@stop

@section('script_plugin')
	@include('plugins.step')
	@include('plugins.select2')
	@include('plugins.microtemplate')
	@include('plugins.input-mask')
@stop
