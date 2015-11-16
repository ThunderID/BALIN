{!! Form::open(['url' => route('frontend.dologin', ['class' => 'hollow-login'])]) !!}
    <div class="form-group">
        <label for="email" style="font-weight:400">Email</label>
        {!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
	    <label for="pwd" style="font-weight:400">Password</label>
	    {!! Form::password('password', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Password', 'required' => 'required']) !!}
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" tabindex="1"> Remember me</label>
	</div>
	<div class="form-group">
	    <button type="submit" class="btn-hollow hollow-black-border " tabindex="1">Sign In</button>
	</div>
	<div class="clearfix">&nbsp;</div>
	<p class="t-xs" style="color:#666">
		Jika anda lupa password klik 
		<a href="javascript:void(0);" class="btn-forgot">Reset Password</a>, 
		dan jika belum punya akun, silahkan klik 
		<a href="javascript:void(0);" class="btn-signup">Sign Up</a> 
		atau login dengan akun sosial,
	</p>
	<a href="{{route('frontend.dosso')}}" class="btn-hollow hollow-black-border hollow-social" title="facebook"><i class="fa fa-facebook"></i></a>
{!! Form::close() !!}