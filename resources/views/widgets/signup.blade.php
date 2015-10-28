{!! Form::open() !!}
	<div class="form-group">
		<label for="">Name</label>
		{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Nama']) !!}
	</div>
	<div class="form-group">
		<label for="">Email</label>
		{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Email']) !!}
	</div>
	<div class="form-group">
		<label for="">Password</label>
		{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Masukkan Password']) !!}
	</div>
	<div class="form-group">
		<label for="">Confirm Password</label>
		{!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => 'Masukkan Confirm Password']) !!}
	</div>
	<div class="checkbox">
		<label class="t-xs" style="color:#666"><input type="checkbox" tabindex="1">I agree to the Terms & Conditions</label>
	</div>
	<div class="form-group">
	    <button type="submit" class="btn-hollow hollow-black" tabindex="1">Sign Up</button>
	    <a class="btn-hollow hollow-black btn-cancel" tabindex="1">Cancel</a>
	</div>
	<div class="clearfix">&nbsp;</div>
	<p class="t-xs" style="color:#666">Or Signup for your social, from</p>
	<div class="form-group">
		<a class="btn-hollow hollow-black hollow-social" tabindex="2" title="facebook"><i class="fa fa-facebook"></i></a>
		<a class="btn-hollow hollow-black hollow-social" tabindex="2" title="twitter"><i class="fa fa-twitter"></i></a>
	</div>
{!! Form::close() !!}