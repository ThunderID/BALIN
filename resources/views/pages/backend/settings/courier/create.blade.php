@inject('data', 'App\Models\Courier')

@if ($id)
	<?php $data = $data::find($id); ?>
@endif

@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.settings.courier.update', $id), 'method' => 'PATCH']) !!}
    @else
        {!! Form::open(['url' => route('backend.settings.courier.store'), 'method' => 'POST']) !!}
    @endif
        {!! Form::hidden('address_id',$data['address']['id']) !!}    
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="form-group">
					{!! HTML::image('http://placehold.it/200x200/bababa/000000/?text=gambar') !!}
					<input type="file" style="opacity:0" class="file-image">
					<a href="#" class="btn btn-sm btn-primary btn-upload m-t-n-md">Upload Gambar</a>
				</div>
			</div>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="parent" class="text-capitalize">Nama</label>
							{!! Form::text('name', $data->name, [
										'class'         => 'form-control', 
										'tabindex'      => '1',
										'placeholder'   => 'Masukkan nama',
							]) !!}
						</div>              
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="parent" class="text-capitalize">Phone</label>
							{!! Form::text('phone', $data['address']['phone'], [
										'class'         => 'form-control', 
										'tabindex'      => '2',
										'placeholder'   => 'Masukkan nomor telepon',
							]) !!}
						</div>              
					</div>					
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="parent" class="text-capitalize">Kode Pos</label>
							{!! Form::text('zipcode', $data['address']['zipcode'], [
										'class'         => 'form-control', 
										'tabindex'      => '3',
										'placeholder'   => 'Masukkan kode pos',
							]) !!}
						</div>              
					</div>						
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="name" class="text-capitalize">Alamat</label>
							{!! Form::textarea('address', $data['address']['address'], [
										'class'         => 'form-control', 
										'required'      => 'required', 
										'rows'          => '3',
										'tabindex'      => '4',
										'style'         => 'resize:none;',
										'placeholder'   => 'Masukkan alamat'
								]) 
							!!}
						</div> 
					</div> 
				</div> 
			</div>
		</div>
		</br>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.courier.index') }}" class="btn btn-md btn-default" tabindex="5">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="6">Simpan</button>
				</div>
			</div>                                     
		</div>
	{!! Form::close() !!}
@stop

@section('script')
	$( document ).ready(function() {
		$('.btn-upload').on('click', function() {
			$('.file-image').trigger('click');
		});
	});
@stop