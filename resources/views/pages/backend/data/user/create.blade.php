@inject('data', 'App\Models\User')
{!! $data = $data::find($id); !!}

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
					{!! Form::text('email', $data['email'], ['class' => 'form-control mod_email', 'required' => 'required', 'tabindex' => '1', 'placeholder' => 'Masukkan email']) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="">Password</label>
					{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Masukkan password', 'tabindex' => '1']) !!}
					<span class="help-block m-b-none">* Biarkan kosong jika tidak ingin mengubah password</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="">Konfirmasi Passowrd</label>
					{!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => 'Masukkan konfirmasi password', 'tabindex' => '1']) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="date_of_birth">Tanggal Lahir</label>
					 {!!Form::input('date', 'date_of_birth', $data['date_of_birth'], ['class' => 'form-control mod_dob', 'required' => 'required', 'tabindex' => '1'] ) !!}
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="gender">Jenis Kelamin</label>
					{!! Form::select('gender', ['male' => 'Male', 'female' => 'Female'], $data['gender'], ['class' => 'form-control', 'required' => 'required', 'tabindex' => '1']) !!}
				</div>  
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="postal_code">Kode Pos</label>
					{!! Form::text('postal_code', $data['postal_code'], ['class' => 'form-control mod_zip', 'required' => 'required', 'tabindex' => '1', 'placeholder' => 'Masukkan kode pos']) !!}
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="phone">Nomor Telepon</label>
					{!! Form::text('phone', $data['phone'], ['class' => 'form-control mod_phone', 'required' => 'required', 'tabindex' => '1', 'placeholder' => 'Masukkan nomor telepon'] ) !!}
				</div>    
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="address">Alamat lengkap</label>
					{!! Form::textarea('address', $data['address'], ['class' => 'form-control mod_address', 'rows' => '3', 'tabindex' => '1', 'style' => 'resize:none;', 'placeholder' => 'Masukkan alamat'] ) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<!-- <div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="role">Role</label>
					{!! Form::select('role', ['cashier' => 'Cashier', 'customer' => 'Customer', 'admin' => 'Admin'], $data['role'], ['class' => 'form-control', 'required' => 'required']) !!}
				</div>
			</div> -->
			@if($data['is_active'])
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="is_active">Status</label>
					{!! Form::select('is_active', [0 => 'Active', 1 => 'Non-Active'], $data['is_active'], ['class' => 'form-control', 'required' => 'required']) !!}
				</div>    
			</div>
			@endif
		</div>
		<div class="row">
			<div class="col-md-12">
				</br>
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.data.customer.index') }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="7">Simpan</button>
				</div>        
			</div>        
		</div>    
	{!! Form::close('') !!}
@stop

@section('script')
@stop