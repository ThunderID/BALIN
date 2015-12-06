@inject('data', 'App\Models\StoreSetting')

<?php 
	$data 	= $data::where('id',$id)->with('images')->first();
	$images = null;
	if(isset($data['images'][0])){
		$images = $data['images'][0];
	}
	$date 	= null;
	$value  = (array)json_decode($data['value'], true);
?>

@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.settings.feature.update', $id), 'method' => 'PATCH', 'class' => 'sliderform']) !!}
    @else
        {!! Form::open(['url' => route('backend.settings.feature.store'), 'method' => 'POST', 'class' => 'sliderform']) !!}
    @endif

		{!! Form::hidden('action', 'preview', ['id' => 'action']) !!}	

		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Pengaturan Slider
				</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="started_at">Tanggal Mulai</label>
					@if($data)
						<?php $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['started_at'])->format('d-m-Y H:i'); ?>					
					@endif
					{!! Form::text('started_at', $date, [
								'tabindex'      => '1', 
								'class'			=> 'date-time-format form-control' 
					]) !!}					
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="ended_at">Tanggal Berakhir</label>
					@if($data && !is_null($data['ended_at']))
						<?php $date2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['ended_at'])->format('d-m-Y H:i'); ?>
					@else
						<?php $date2 = null;?>
					@endif
					{!! Form::text('ended_at', $date2, [
								'tabindex'      => '1', 
								'class'			=> 'date-time-format form-control' 
					]) !!}					
				</div>  
			</div> 
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Gambar Slider
				</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="thumbnail" class="text-capitalize">URL Image Thumbnail</label>
					{!! Form::text('thumbnail', $images['thumbnail'], [
								'class'         => 'form-control', 
								'tabindex'      => '2',
								'placeholder'   => 'Masukkan url image thumbnail',
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image XS</label>
					{!! Form::text('image_xs', $images['image_xs'], [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'   => 'Masukkan url image xs',
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image SM</label>
					{!! Form::text('image_sm', $images['image_sm'], [
								'class'         => 'form-control', 
								'tabindex'      => '4',
								'placeholder'   => 'Masukkan url image sm',
					]) !!}
				</div>
			</div>											
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image MD</label>
					{!! Form::text('image_md', $images['image_md'], [
								'class'         => 'form-control', 
								'tabindex'      => '5',
								'placeholder'   => 'Masukkan url image md',
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image LG</label>
					{!! Form::text('image_lg', $images['image_lg'], [
								'class'         => 'form-control', 
								'tabindex'      => '6',
								'placeholder'   => 'Masukkan url image lg',
					]) !!}							
				</div>
			</div>
			<div class="col-md-4">
			</div>					
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Judul Slider
				</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 ">
				<div class="form-group">
					<label for="title_active" class="text-capitalize">Aktifkan Judul</label>
					{!! Form::select('title_active', [
							'0' 					=> 'Non Aktif',
							'1' 					=> 'Aktif',
						], 
						isset($value['title']['title_active']) ? $value['title']['title_active'] : '', 
						[
							'class' 				=> 'form-control slider-text-switch', 
							'id'					=> 'slider-title',
							'tabindex' 				=> '7'
						]) 
					!!}								
				</div>				
			</div>
			<div class="col-md-6 ">
				<div class="form-group">
					<label for="slider_title_location" class="text-capitalize">Posisi Judul</label>
					{!! Form::select('slider_title_location', [
							'Top-Left' 				=> 'Top-Left',
							'Top-Center' 			=> 'Top-Center',
							'Top-Right' 			=> 'Top-Right',
							'Center-Left' 			=> 'Center-Left',
							'Center-Center' 		=> 'Center-Center',
							'Center-Right' 			=> 'Center-Right',
							'Bottom-Left' 			=> 'Bottom-Left',
							'Bottom-Center' 		=> 'Bottom-Center',
							'Bottom-Right' 			=> 'Bottom-Right',															
						], 
						isset($value['title']['slider_title_location']) ? $value['title']['slider_title_location'] : '', 
						[
							'class' 				=> 'form-control', 
							'tabindex' 				=> '8'
						]) 
					!!}														
				</div>				
			</div>
			<div class="col-md-12 ">
				<div class="form-group">
					<label for="slider_title" class="text-capitalize">Teks Judul</label>
					{!! Form::text('slider_title', isset($value['title']['slider_title']) ? $value['title']['slider_title'] : '', [
								'class'         => 'form-control', 
								'tabindex'      => '9',
								'placeholder'   => 'Masukkan title slider',
					]) !!}										
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Konten Slider
				</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 slider-title">
				<div class="form-group">
					<label for="content_active" class="text-capitalize">Aktifkan Konten</label>
					{!! Form::select('content_active', [
							'0' 					=> 'Non Aktif',
							'1' 					=> 'Aktif',
						], 
						isset($value['content']['content_active']) ? $value['content']['content_active'] : '', 
						[
							'class' 				=> 'form-control slider-text-switch', 
							'tabindex' 				=> '10',
							'id'					=> 'slider-content'
						]) 
					!!}								
				</div>				
			</div>
			<div class="col-md-6 ">
				<div class="form-group">
					<label for="slider_content_location" class="text-capitalize">Posisi Konten</label>
					{!! Form::select('slider_content_location', [
							'Top-Left' 				=> 'Top-Left',
							'Top-Center' 			=> 'Top-Center',
							'Top-Right' 			=> 'Top-Right',
							'Center-Left' 			=> 'Center-Left',
							'Center-Center'			=> 'Center-Center',
							'Center-Right' 			=> 'Center-Right',
							'Bottom-Left' 			=> 'Bottom-Left',
							'Bottom-Center' 		=> 'Bottom-Center',
							'Bottom-Right' 			=> 'Bottom-Right',															
						], 
						isset($value['content']['slider_content_location']) ? $value['content']['slider_content_location'] : '',
						[
							'class' 				=> 'form-control',
							'id'					=> 'slider-content', 
							'tabindex' 				=> '11'
						]) 
					!!}														
				</div>				
			</div>
			<div class="col-md-12 ">
				<div class="form-group">
					<label for="slider_content" class="text-capitalize">Konten Slider</label>
					{!! Form::textarea('slider_content', isset($value['content']['slider_content']) ? $value['content']['slider_content'] : '', [
								'class'         => 'form-control', 
								'tabindex'      => '12',
								'rows'			=> '3',
								'style'        	=> 'resize:none;',
								'placeholder'   => 'Masukkan teks konten',
					]) !!}										
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Tombol Slider
				</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 ">
				<div class="form-group">
					<label for="button_active" class="text-capitalize">Aktifkan Tombol</label>
					{!! Form::select('button_active', [
							'0' 					=> 'Non Aktif',
							'1' 					=> 'Aktif',
						], 
						isset($value['button']['button_active']) ? $value['button']['button_active'] : '',
						[
							'class' 				=> 'form-control slider-text-switch', 
							'tabindex' 				=> '13',
							'id'					=> 'slider-button'
						]) 
					!!}								
				</div>				
			</div>
			<div class="col-md-6 ">
				<div class="form-group">
					<label for="slider_button_location" class="text-capitalize">Posisi Tombol</label>
					{!! Form::select('slider_button_location', [
							'Top-Left' 				=> 'Top-Left',
							'Top-Center' 			=> 'Top-Center',
							'Top-Right' 			=> 'Top-Right',
							'Center-Left' 			=> 'Center-Left',
							'Center-Center' 		=> 'Center-Center',
							'Center-Right' 			=> 'Center-Right',
							'Bottom-Left' 			=> 'Bottom-Left',
							'Bottom-Center' 		=> 'Bottom-Center',
							'Bottom-Right' 			=> 'Bottom-Right',															
						], 
						isset($value['button']['slider_button_location']) ? $value['button']['slider_button_location'] : '',
						[
							'class' 				=> 'form-control', 
							'tabindex' 				=> '14'
						]) 
					!!}														
				</div>				
			</div>
			<div class="col-md-6 ">
				<div class="form-group">
					<label for="slider_button_text" class="text-capitalize">Teks Tombol</label>
					{!! Form::text('slider_button_text', isset($value['button']['slider_button']) ? $value['button']['slider_button'] : '', [
								'class'         => 'form-control', 
								'tabindex'      => '15',
								'placeholder'   => 'Masukkan teks tombol',
					]) !!}										
				</div>
			</div>
			<div class="col-md-6 ">
				<div class="form-group">
					<label for="slider_button_url" class="text-capitalize">URL Tombol</label>
					{!! Form::text('slider_button_url', isset($value['button']['slider_button_url']) ? $value['button']['slider_button_url'] : '', [
								'class'         => 'form-control btn-url', 
								'tabindex'      => '16',
								'placeholder'   => 'Masukkan URL tombol',
					]) !!}										
				</div>
			</div>
		</div>


		<div class="row clearfix">
			&nbsp;
		</div>

		<div class="row clearfix">
			&nbsp;
		</div>		

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.feature.index') }}" class="btn btn-md btn-default" tabindex="17">Batal</a>
					<!-- <button type="submit" class="btn btn-md btn-primary" tabindex="18" name="action" value="preview">Preview</button> -->
					<a onclick="preview()" href="javascript:void(0);" class="btn btn-md btn-primary" tabindex="18" name="action" value="preview">Preview</a>
					<a onclick="store()" href="javascript:void(0);" class="btn btn-md btn-primary" tabindex="18" name="action" value="store">Simpan</a>
					<!-- <button type="submit" class="btn btn-md btn-primary" tabindex="18" name="action" value="store">Simpan</button> -->
				</div>
			</div>                                     
		</div>


	{!! Form::close() !!}
@stop

@section('script')
	$(document).ready(function() {
		checkStatus($('#slider-title'));
		checkStatus($('#slider-content'));
		checkStatus($('#slider-button'));
	});

	$('.slider-text-switch').change(function() {
		checkStatus($(this));
	});

	function checkStatus(e) {
		var stat = false;
		if(e.val() == 0)
		{
			stat = true;
		}

		e.parent().parent().siblings().find('.form-control').prop( "disabled", stat );
		e.parent().parent().siblings().find('.form-control.btn-url').prop( "disabled", false );
	}

	function store() {
		$('.sliderform').attr("target", "");
		$('#action').val('store');
		$('.sliderform').submit();
	}

	function preview() {
		$('.sliderform').attr("target", "_blank");
		$('#action').val('preview');
		$('.sliderform').submit();
	}

@stop

@section('script_plugin')
	@include('plugins.input-mask')
@stop