@inject('data', 'App\Models\ShippingCost')
<?php 
		$data = $data::where('id', $id)
							->first(); 

?>
@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.settings.shippingCost.update', ['cou_id' => $cou_id, 'id' => $id]), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.settings.shippingCost.store', ['cou_id' => $cou_id, 'id' => $id]), 'method' => 'POST']) !!}
	@endif
        {!! Form::hidden('id',$data['id']) !!}    
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Kurir
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="courier_id">{{$courier['name']}}</label>
					{!! Form::hidden('courier_id', $cou_id, [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
					]) !!}
				</div>  
			</div>                                        
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Kode Pos
				</h4>
			</div>
		</div>		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="start_postal_code">Awal Kode pos</label>
					{!! Form::text('start_postal_code', $data['start_postal_code'], [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan kode pos'
					]) !!}					
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="end_postal_code">Akhir Kode pos</label>
					{!! Form::text('end_postal_code', $data['end_postal_code'], [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan kode pos'
					]) !!}					
				</div>
			</div>			
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Biaya
				</h4>
			</div>
		</div>		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="cost">Biaya Kirim</label>
					{!! Form::text('cost', $data['cost'], [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan biaya kirim'
					]) !!}	
				</div>  
			</div> 

		<?php
			$date = Null;
			$time = Null;
			if (isset($data['started_at']))
			{
				$date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['started_at'])->format('Y-m-d');
				$time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['started_at'])->format('H:i');
			}
		?>

			<div class="col-md-4">
				<div class="form-group">
					<label for="start_date" class="text-capitalize">Waktu Berlaku</label>
					{!! Form::input('date','date', $date, [
								'class'         		=> 'form-control input-date', 
								'tabindex'      		=> '1',
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
								'tabindex'      => '1',
								'placeholder'   => 'hh:ii',
								'style'			 => 'margin-top:23px'
					]) !!}
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.courier.show', ['id' => $cou_id ]) }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="9">Simpan</button>
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