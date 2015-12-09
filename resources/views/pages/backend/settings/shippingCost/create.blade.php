@inject('data', 'App\Models\ShippingCost')
<?php 
		$data = $data::where('id', $id)
							->first(); 

?>
@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				{{$courier['name']}}
			</h4>
		</div>
	</div>
	@if(is_null($id))
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Impor CSV
			</h4>
		</div>
	</div>
	{!! Form::open(['url' => route('backend.settings.shippingcost.import', ['cou_id' => $cou_id, 'id' => $id]), 'class' => 'form no_enter', 'files' => true]) !!}	
        {!! Form::hidden('courier_id', $cou_id) !!}  
		<div class="clearfix">&nbsp;</div>
		<div class="form-group">
			<label>Browse CSV</label>
			<input type="file" name="file_csv">
			<span id="helpBlock" class="help-block font-12">* Masukkan dalam bentuk .csv</span>
		</div>

		<div class="form-group text-right">
			<input class="btn btn-primary" type="submit" value="Simpan">
		</div>
		{!! Form::close() !!}
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Manual Input
				</h4>
			</div>
		</div>
	@endif
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.settings.shippingCost.update', ['cou_id' => $cou_id, 'id' => $id]), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.settings.shippingCost.store', ['cou_id' => $cou_id, 'id' => $id]), 'method' => 'POST']) !!}
	@endif
        {!! Form::hidden('courier_id', $cou_id) !!}  
        {!! Form::hidden('id',$data['id']) !!}  
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
								'tabindex'      => '2', 
								'placeholder'   => 'Masukkan kode pos'
					]) !!}					
				</div>
			</div>			
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="cost">Biaya Kirim</label>
					{!! Form::text('cost', $data['cost'], [
								'class'         => 'form-control money', 
								'tabindex'      => '3', 
								'placeholder'   => 'Masukkan biaya kirim'
					]) !!}	
				</div>  
			</div> 

		<?php
			$date = Null;
			$time = Null;
			if (isset($data['started_at']))
			{
				$date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['started_at'])->format('d-m-Y H:i');
			}
		?>

			<div class="col-md-6">
				<div class="form-group">
					<label for="start_date" class="text-capitalize">Waktu Berlaku</label>
					{!! Form::input('text','date', $date, [
								'class'         		=> 'form-control date-time-format', 
								'tabindex'      		=> '5',
								'placeholder'   		=> 'dd-mm-yyyy hh:mm',
								'data-date'		 		=> '',
								'data-date-format'		=> 'dd-mm-yyyy hh:mm',
					]) !!}
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.courier.show', ['id' => $cou_id ]) }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="7">Simpan</button>
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
	@include('plugins.input-mask')
	@include('plugins.summernote')
	@include('plugins.jquery-upload')
@stop