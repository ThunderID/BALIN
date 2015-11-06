@inject('data', 'App\Models\PointLog')
<?php 
		$data = $data::where('id', $id)
							->first(); 

?>
@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.data.pointlog.update', ['user_id' => $user_id, 'id' => $id]), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.data.pointlog.store', ['user_id' => $user_id, 'id' => $id]), 'method' => 'POST']) !!}
	@endif
        {!! Form::hidden('id',$data['id']) !!}    
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Kostumer
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="user_id">{{$user['name']}}</label>
					{!! Form::hidden('user_id', $user_id, [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
					]) !!}
				</div>  
			</div>                                        
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="amount">Jumlah</label>
					{!! Form::text('amount', $data['amount'], [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan jumlah'
					]) !!}					
				</div>
			</div>
		<?php
			$date = Null;
			$time = Null;
			if (isset($data['expired_at']))
			{
				$date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['expired_at'])->format('Y-m-d');
				$time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['expired_at'])->format('H:i');
			}
		?>

			<div class="col-md-4">
				<div class="form-group">
					<label for="start_date" class="text-capitalize">Expire</label>
					{!! Form::input('date','date', $date, [
								'class'         		=> 'form-control input-date', 
								'tabindex'      		=> '2',
								'placeholder'   		=> 'dd-mm-yyyy',
								'data-date'		 		=> '',
								'data-date-format'		=> 'dd-mm-yyyy',
					]) !!}
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					{!! Form::input('time','time', $time, [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'   => 'hh:ii',
								'style'			 => 'margin-top:23px'
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="notes">Catatan</label>
					{!! Form::textarea('notes', $data['notes'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Tuliskan catatan',
								'rows'          => '2',
								'tabindex'      => '4',
								'style'         => 'resize:none;',
					]) !!}
				</div>            
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.courier.show', ['id' => $user_id ]) }}" class="btn btn-md btn-default" tabindex="5">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="6">Simpan</button>
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
	@include('plugins.jquery-upload')
@stop