@extends('template.campaign.layout_campaign')

@section('content')
	<div class="container-fluid softlaunch-sign-up" style="">
		<div class="row m-t-xl">
			<div class="col-xs-12 col-sm-5 col-sm-offset-7 col-md-5 col-md-offset-7 col-lg-5 col-lg-offset-7">
				<?php
				function isMobile() {
				    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
				}
				?>	

				<div class="form-softlaunch p-sm m-t-xl">
					<h3 class="m-t-xs">Early Sign Up</h3>
					{!! Form::open(['url' => route('frontend.user.store')]) !!}
						<div class="form-group">
							<label for="" style="font-weight:400">Name</label>
							{!! Form::text('name', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Nama', 'required']) !!}
						</div>
						<div class="form-group">
							<label for="" style="font-weight:400">Email</label>
							{!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email', 'required']) !!}
						</div>
						<div class="form-group">
							<label for="" style="font-weight:400">Password</label>
							{!! Form::password('password', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Password', 'required']) !!}
						</div>
						<div class="form-group">
							<label for="" style="font-weight:400">Konfirmasi Password</label>
							{!! Form::password('password_confirmation', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Konfirmasi Password', 'required']) !!}
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
						@if(isset($is_invitation))
							<div class="form-group">
								<label for="" style="font-weight:400">Promo Referral</label>
								{!! Form::text('voucher', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Promo Referral', 'required']) !!}
							</div>
						@endif
						<div class="checkbox">
							<label class="t-xs" style="color:#666">
								<input type="checkbox" required>
								Saya menyetujui <a href="#" class="link-black hover-grey unstyle" data-toggle="modal" data-target="#tnc"><strong>Syarat & Ketentuan</strong></a> untuk melakukan pendaftaran.. 
							</label>
						</div>
						<div class="form-group text-left">
						    <button type="submit" class="btn-hollow hollow-black-border">Sign Up</button>
						</div>
						<div class="form-group text-left m-t-xl m-b-xs">
						    <button type="submit" class="btn-hollow hollow-black-border"><i class="fa fa-facebook"></i>&nbsp; Sign Up with Facebook</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>	
	</div>
@stop

@section('script_plugin')
	@include('plugins.input-mask')
@stop