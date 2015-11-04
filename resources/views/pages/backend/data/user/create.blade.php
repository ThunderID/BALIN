@inject('data', 'App\Models\User')
{!! $data = $data::findornew($id); !!}

@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.data.customer.update', $id), 'method' => 'PATCH']) !!}
    @else
        {!! Form::open(['url' => route('backend.data.customer.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="name">Nama Lengkap</label>
					{!! Form::text('name', $data['name'], ['class' => 'form-control mod_name', 'required' => 'required', 'tabindex' => '1', 'placeholder' => 'Masukkan nama lengkap customer'] ) !!}
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="email">Email</label>
					{!! Form::text('email', $data['email'], ['class' => 'form-control mod_email', 'required' => 'required', 'tabindex' => '2', 'placeholder' => 'Masukkan email']) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="">Password</label>
					{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Masukkan password', 'tabindex' => '3']) !!}
					<span class="help-block m-b-none">* Biarkan kosong jika tidak ingin mengubah password</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="">Konfirmasi Passowrd</label>
					{!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Masukkan konfirmasi password', 'tabindex' => '4']) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="date_of_birth">Tanggal Lahir</label>
					 {!!Form::input('date', 'date_of_birth', (!is_null($data['date_of_birth']) ? $data['date_of_birth']->format('d-m-Y') : ''), ['class' => 'form-control mod_dob', 'required' => 'required', 'tabindex' => '5'] ) !!}
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="gender">Jenis Kelamin</label>
					{!! Form::select('gender', ['male' => 'Male', 'female' => 'Female'], $data['gender'], ['class' => 'form-control', 'required' => 'required', 'tabindex' => '6']) !!}
				</div>  
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="role">Role</label>
					{!! Form::select('role', ['store_manager' => 'Store Manager', 'customer' => 'Customer', 'admin' => 'Admin'], $data['role'], ['class' => 'form-control', 'required' => 'required', 'tabindex' => '7']) !!}
				</div>
			</div>
			<!-- <div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="is_active">Status</label>
					{!! Form::select('is_active', [0 => 'Active', 1 => 'Non-Active'], $data['is_active'], ['class' => 'form-control', 'required' => 'required', 'tabindex' => '8']) !!}
				</div>
			</div> -->
		</div>

		<div class="row">
			<div class="col-md-12">
				</br>
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.data.customer.index') }}" class="btn btn-md btn-default" tabindex="9">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="10">Simpan</button>
				</div>        
			</div>        
		</div>    
	{!! Form::close() !!}
@stop
