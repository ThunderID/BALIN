{!! Form::open(['url' => route('frontend.user.store')]) !!}
	<div class="form-group">
		<label for="">Name</label>
		{!! Form::text('name', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Nama']) !!}
	</div>
	<div class="form-group">
		<label for="">Email</label>
		{!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email']) !!}
	</div>
	<div class="form-group">
		<label for="">Password</label>
		{!! Form::password('password', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Password']) !!}
	</div>
	<div class="form-group">
		<label for="">Konfirmasi Password</label>
		{!! Form::password('password_confirmation', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Konfirmasi Password']) !!}
	</div>
	<div class="form-group">
		<label for="">Tanggal Lahir</label>
		{!! Form::text('date_of_birth', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Tanggal Lahir']) !!}
	</div>
	<div class="form-group">
		<label for="">Jenis Kelamin</label>
		{!! Form::select('gender', ['male' => 'Laki-laki', 'female' => "Perempuan"], null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Jenis Kelamin']) !!}
	</div>
	<div class="form-group">
		<label for="">Alamat</label>
		{!! Form::textarea('address', null, [
				'class' => 'form-control hollow', 
				'placeholder' => 'Masukkan Alamat', 
				'rows' => '3',
				'style' => 'resize:none'
		]) !!}
	</div>
	<div class="checkbox">
		<label class="t-xs" style="color:#666">
			<input type="checkbox" tabindex="1" required>Setuju dengan Terms & Conditions
		</label>
	</div>
	<div class="form-group">
	    <button type="submit" class="btn-hollow hollow-black" tabindex="1">Sign Up</button>
	    <a class="btn-hollow hollow-black btn-cancel" tabindex="1">Cancel</a>
	</div>
	<div class="clearfix">&nbsp;</div>
	<p class="t-xs" style="color:#666">Atau Signup dari akun sosial anda,</p>
	<div class="form-group">
		<a class="btn-hollow hollow-black hollow-social" tabindex="2" title="facebook"><i class="fa fa-facebook"></i></a>
	</div>
{!! Form::close() !!}