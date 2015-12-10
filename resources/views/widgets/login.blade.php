{!! Form::open(['url' => route('frontend.dologin', ['class' => 'hollow-login'])]) !!}
    <div class="form-group">
        <label for="email" style="font-weight:400">Email</label>
        {!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
	    <label for="pwd" style="font-weight:400">Password</label>
	    {!! Form::password('password', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Password', 'required' => 'required']) !!}
	</div>
	{{-- <div class="checkbox">
	    <label><input type="checkbox"> Remember me</label>
	</div> --}}
	<div class="form-group">
		<a href="javascript:void(0);" class="btn-forgot t-xs hover-black" style="color:#666; margin-left:3px;">Lupa Password?</a>
	    <button type="submit" class="pull-right btn-hollow hollow-black-border ">Sign In</button>
	</div>
	<div class="clearfix">&nbsp;</div>
	<h3 style="margin-top:3px;">Join Us</h3>
	<p class="t-xs" style="color:#666">
		Connect dengan akun Facebook Anda atau daftarkan email Anda untuk menikmati penawaran spesial dari Kami.
	</p>
	<div class="row" style="margin-top:12px;">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<a href="javascript:void(0);" class="btn-signup btn-hollow btn-xs btn-block hollow-black-border">
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 p-l-none">
					<i class="fa fa-envelope-o"></i>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-10 p-l-none p-r-none text-left">
					&nbsp; Mendaftar
				</div>
			</a>
		</div>	
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<div class="row clearfix" style="margin-top:10px;">
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<a href="{{route('frontend.dosso')}}" class="btn-hollow btn-xs btn-block hollow-black-border hollow-social" title="facebook">
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 p-l-none">
					<i class="fa fa-facebook" style="margin-top: 3px;"></i>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-10 p-l-none p-r-none text-left">
					&nbsp; Facebook Connect
				</div>
			</a>
		</div>
	</div>	
{!! Form::close() !!}