{!! Form::open(['url' => route('frontend.user.store')]) !!}
	<div class="form-group">
		<label for="" style="font-weight:400">Name</label>
		{!! Form::text('name', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Nama']) !!}
	</div>
	<div class="form-group">
		<label for="" style="font-weight:400">Email</label>
		{!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email']) !!}
	</div>
	<div class="form-group">
		<label for="" style="font-weight:400">Password</label>
		{!! Form::password('password', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Password']) !!}
	</div>
	<div class="form-group">
		<label for="" style="font-weight:400">Konfirmasi Password</label>
		{!! Form::password('password_confirmation', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Konfirmasi Password']) !!}
	</div>
	<div class="form-group">
		<label for="" style="font-weight:400">Tanggal Lahir</label>
		{!! Form::text('date_of_birth', null, ['class' => 'form-control hollow date-format', 'placeholder' => 'Masukkan Tanggal Lahir']) !!}
	</div>
	<div class="form-group">
		<label for="" style="font-weight:400">Jenis Kelamin</label>
		{!! Form::select('gender', ['male' => 'Laki-laki', 'female' => "Perempuan"], null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Jenis Kelamin']) !!}
	</div>
	{{-- <div class="form-group">
		<label for="" style="font-weight:400">Alamat</label>
		{!! Form::textarea('address', null, [
				'class' => 'form-control hollow', 
				'placeholder' => 'Masukkan Alamat', 
				'rows' => '3',
				'style' => 'resize:none'
		]) !!}
	</div> --}}
	<div class="checkbox">
		<label class="t-xs" style="color:#666">
			<input type="checkbox" tabindex="1" required>
			Saya menyetujui <a href="#" class="link-black hover-grey unstyle" data-toggle="modal" data-target="#tnc"><strong>Syarat & Ketentuan</strong></a> untuk melakukan pendaftaran.. 
		</label>
	</div>
	<div class="form-group">
	    <button type="submit" class="btn-hollow hollow-black-border" tabindex="1">Sign Up</button>
	    <a class="btn-hollow hollow-black-border btn-cancel" tabindex="1">Cancel</a>
	</div>
	<div class="clearfix">&nbsp;</div>
	<p class="t-xs" style="color:#666">Atau Signup dari akun sosial anda,</p>
	<div class="form-group">
		<a href="{{route('frontend.dosso')}}" class="btn-hollow hollow-black hollow-social" tabindex="2" title="facebook"><i class="fa fa-facebook"></i></a>
	</div>
{!! Form::close() !!}