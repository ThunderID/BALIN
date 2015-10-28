{!! Form::open() !!}
    <div class="form-group">
        <label for="email">Email address</label>
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Email', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
	    <label for="pwd">Password</label>
	    {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" tabindex="1"> Remember me</label>
	</div>
	<div class="form-group">
	    <button type="submit" class="btn-hollow hollow-black" tabindex="1">Sign In</button>
	</div>
	<div class="clearfix">&nbsp;</div>
	<p class="t-xs" style="color:#666">If you don't have account? Please <a href="#" class="btn-signup">Sign Up</a> or login from,</p>
	<a href="#" class="btn-hollow hollow-social hollow-black"><i class="fa fa-facebook"></i></a>
	<a href="#" class="btn-hollow hollow-social hollow-black"><i class="fa fa-twitter"></i></a>
{!! Form::close() !!}