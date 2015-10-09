@inject('data', 'App\Models\User')
{!! $data = $data::Customer($id)
						->first(); 
!!}

@extends('template.backend.layout') 

@section('content')
	{!! Form::open(['route' => 'backend.customer.store']) !!}
		{!! Form::input('hidden', 'id', $data['id']) !!}
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="name">Nama Lengkap</label>
					{!! Form::text('name', $data['name'], ['class' => 'form-control mod_name', 'required' => 'required', 'tabindex' => '1'] ) !!}
				</div>
				<div class="form-group">
					<label for="gender">Jenis Kelamin</label>
					{!! Form::text('gender', $data['gender'], ['class' => 'form-control mod_gender', 'required' => 'required', 'tabindex' => '1'] ) !!}
				</div>                                      
				<div class="form-group">
					<label for="dob">Tanggal Lahir</label>
					{!! Form::text('dob', $data['date_of_birth'], ['class' => 'form-control mod_dob', 'required' => 'required', 'tabindex' => '1'] ) !!}
				</div>  
				<div class="form-group">
					<label for="email">Email</label>
					{!! Form::text('email', $data['email'], ['class' => 'form-control mod_email', 'required' => 'required', 'tabindex' => '1'] ) !!}
				</div>  
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="phone">Nomor Telepon</label>
					{!! Form::text('phone', $data['phone'], ['class' => 'form-control mod_phone', 'required' => 'required', 'tabindex' => '1'] ) !!}
				</div> 
				<div class="form-group">
					<label for="address">Alamat lengkap</label>
					{!! Form::textarea('address', $data['address'], ['class' => 'form-control mod_address', 'rows' => '3', 'tabindex' => '1', 'style' => 'resize:none;'] ) !!}
				</div>
				<div class="form-group">
					<label for="zip">Kode Pos</label>
					{!! Form::text('zip', $data['zip'], ['class' => 'form-control mod_zip', 'required' => 'required', 'tabindex' => '1'] ) !!}
				</div>    
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				</br>
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.customer.index') }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
					<button type="submit" class="btn btn-md btn-success" tabindex="7">Simpan</button>
				</div>        
			</div>        
		</div>    
	{!! Form::close('') !!}
@stop

@section('script')
@stop