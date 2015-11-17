@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-sm-12">
			<h3 class="page-title m-t-0">{{$title}}</h3>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12">
		    {!! Form::open(['url' => route('frontend.profile.update'), 'method' => 'POST']) !!}
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="name">Nama Lengkap</label>
							{!! Form::text('name', Auth::user()['name'], ['class' => 'form-control hollow mod_name', 'required' => 'required', 'tabindex' => '1', 'placeholder' => 'Masukkan nama lengkap'] ) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="email">Email</label>
							{!! Form::text('email', Auth::user()['email'], ['class' => 'form-control hollow mod_email', 'tabindex' => '2', 'placeholder' => 'Masukkan email', 'disable']) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="date_of_birth">Tanggal Lahir</label>
							 {!!Form::input('date', 'date_of_birth', (!is_null(Auth::user()['date_of_birth']) ? Auth::user()['date_of_birth']->format('d-m-Y') : ''), ['class' => 'form-control hollow mod_dob', 'required' => 'required', 'tabindex' => '3', 'placeholder' => 'Masukkan tanggal lahir'] ) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="gender">Jenis Kelamin</label>
							{!! Form::select('gender', ['male' => 'Pria', 'female' => 'Wanita'], Auth::user()['gender'], ['class' => 'form-control hollow', 'required' => 'required', 'tabindex' => '4']) !!}
						</div>  
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Password</label>
							{!! Form::password('password', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan password', 'tabindex' => '5']) !!}
							<span class="help-block m-b-none">* Biarkan kosong jika tidak ingin mengubah password</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Konfirmasi Password</label>
							{!! Form::password('password_confirmation', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan konfirmasi password', 'tabindex' => '6']) !!}
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						</br>
						<div class="form-group text-right">
							<button type="submit" class="btn-hollow hollow-black" tabindex="7">Simpan</button>
						</div>        
					</div>        
				</div>    
			{!! Form::close() !!}
		</div>
	</div>
@stop