@extends('template.backend.layout')

@section('content')
	{!! Form::open(['route' => 'backend.updatePassword']) !!}
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Password Lama</label>
					{!! Form::password('password', [
								'class'         => 'form-control',
								'tabindex'      => '1',
								'placeholder'   => 'Masukkan password lama',
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="name" class="text-capitalize">Password Baru</label>
					{!! Form::password('new_password', [
								'class'         => 'form-control',
								'tabindex'      => '2',
								'placeholder'   => 'Masukkan password lama'
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="name" class="text-capitalize">Konfirmasi Password</label>
					{!! Form::password('new_password_confirmation', [
								'class'         => 'form-control',
								'tabindex'      => '3',
								'placeholder'   => 'Masukkan konfirmasi password'
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.settings.category.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop