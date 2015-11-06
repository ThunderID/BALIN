{!! Form::open(['url' => route('frontend.dologin')]) !!}
    <div class="form-group">
        <label for="email">Email</label>
        {!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
	    <label for="pwd">Password</label>
	    {!! Form::password('password', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Password', 'required' => 'required']) !!}
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" tabindex="1"> Remember me</label>
	</div>
	<div class="form-group">
	    <button type="submit" class="btn-hollow hollow-black" tabindex="1">Sign In</button>
	</div>
	<div class="clearfix">&nbsp;</div>
	<p class="t-xs" style="color:#666">
		Jika anda lupa password klik 
		<a href="javascript:void(0);" class="btn-forgot">Lupa Password</a>, 
		dan jika belum punya akun, silahkan klik 
		<a href="javascript:void(0);" class="btn-signup">Sign Up</a> 
		atau login dengan akun sosial,
	</p>
	<a href="#" class="btn-hollow hollow-social hollow-black"><i class="fa fa-facebook"></i></a>
{!! Form::close() !!}