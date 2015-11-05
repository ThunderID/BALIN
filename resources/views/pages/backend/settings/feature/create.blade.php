@inject('data', 'App\Models\StoreSetting')

<?php 
	$data 	= $data::where('id',$id)->with('images')->first();
	$images = $data['images'][0];
	$date 	= null;
?>

@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.settings.feature.update', $id), 'method' => 'PATCH']) !!}
    @else
        {!! Form::open(['url' => route('backend.settings.feature.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-12">
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
				<div class="form-group">
					<label for="value" class="text-capitalize">Kontent Slider</label>
					{!! Form::textarea('value', $data['value'], [
								'class'         => 'form-control summernote', 
								'tabindex'      => '7',
								'style'        	=> 'resize:none;',
					]) !!}					
				</div>
			</div>
		</div>
		</br>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.feature.index') }}" class="btn btn-md btn-default" tabindex="8">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="9">Simpan</button>
				</div>
			</div>                                     
		</div>
	{!! Form::close() !!}
@stop
