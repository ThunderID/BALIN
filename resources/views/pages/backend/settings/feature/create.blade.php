@inject('data', 'App\Models\FeaturedProduct')

@if ($id)
	<?php $data = $data::find($id); ?>
@endif

@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.settings.feature.update', $id), 'method' => 'PATCH']) !!}
    @else
        {!! Form::open(['url' => route('backend.settings.feature.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Up</label>
					{!! Form::text('started_at', $data['started_at'], [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
								'placeholder'   => 'Y-m-d H:i:s'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">To</label>
					{!! Form::text('ended_at', $data['ended_at'], [
								'class'         => 'form-control', 
								'tabindex'      => '2', 
								'placeholder'   => 'Y-m-d H:i:s'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-12">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Caption</label>
					{!! Form::text('title', $data['title'], [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'	=> 'caption',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Text</label>
					{!! Form::textarea('description', $data['description'], [
								'class'         => 'form-control', 
								'tabindex'      => '4',
								'placeholder'	=> 'caption',
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.feature.index') }}" class="btn btn-md btn-default" tabindex="5">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="6">Simpan</button>
				</div>
			</div>                                     
		</div>
	{!! Form::close() !!}
@stop
