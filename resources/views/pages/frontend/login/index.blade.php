@inject('store', 'App\Models\StoreSetting')

<?php 
	$stores			= $store->type('why_join')->Ondate('now')->first();
	$tc 			= $store->type('term_and_condition')->ondate('now')->orderby('started_at', 'desc')->first();
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container-fluid page-join" style="">
		<div class="row mt-75 mobile-m-t-25" style="">
			<div class="col-md-12">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-5 col-xs-12 hidden-xs">
									 <div class="row">
										<div class="col-md-12">
											<!-- {!! $stores['value'] !!} -->
										</div>
									</div>
									<div class="clearfix">&nbsp;</div>
								</div>
								<div class="col-md-5 col-xs-12 col-md-offset-2">
									<div class="row panel-hollow panel-default p-xs m-t-n-xs">
										<div class="col-md-12">
											<div class="sign-in" style="@if (Session::has('msg-from')) @if (Session::get('msg-from')=='login') display:block; @else display:none; @endif @else display:block; @endif">
												<h3>Sign In</h3>
												@if (Session::has('msg-from') && Session::get('msg-from')=='login')
													@include('widgets.alerts')
												@endif
												@include('widgets.login')
											</div>
											<div class="sign-up" style="@if (Session::has('msg-from') && Session::get('msg-from')=='sign-up') display:block; @else display:none; @endif">
												<h3>Sign Up</h3>
												@if (Session::has('msg-from') && Session::get('msg-from')=='sign-up')
													@include('widgets.alerts')
												@endif
												@include('widgets.signup')
												<p class="t-xs" style="color:#666">Atau Signup dari akun sosial anda,</p>
												<div class="form-group">
													<a href="{{route('frontend.dosso')}}" class="btn-hollow hollow-black-border hollow-social" tabindex="2" title="facebook"><i class="fa fa-facebook"></i></a>
												</div>
											</div>
											<div class="forgot" style="display:none">
												<h3>Reset Password</h3>
												<div class="clearfix">&nbsp;</div>
												@include('widgets.forgot_password')
											</div>
										</div>	
										<div class="clearfix">&nbsp;</div>
									</div>                        
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>

		<!-- Term and Condition -->
		<div id="tnc" class="modal modal-left modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center" id="exampleModalLabel">Syarat & Ketentuan</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12" style="color: #222; font-weight: 300">
								{!! $tc['value'] !!}
							</div>
						</div>
						<div class="row m-t-md">
							<div class="col-md-12">
								<button type="button" class="btn-hollow hollow-black-border" data-dismiss="modal" aria-label="Close">Tutup</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>			
	</div>
@stop

@section('script')
 /* $('document').ready(function() {
		$('body').attr('style', 'background-image: url("http://localhost:8000/Balin/web/image/2.jpg")');
		$('.page-join').height(($(window).height())+$('footer.footer').height());
	});
	$('.btn-signup').click( function() {
		$('.sign-up').show();
		$('.sign-in').hide();
		$('.page-join').animate({ height: ($(window).height())+1 }, "slow");
	});
	$('.btn-cancel').click( function() {
		$('.sign-up').hide();
		$('.sign-in').show();
		$('.page-join').animate({ height: ($(window).height())+1 }, "slow");
	}); */

	$('.btn-signup').click( function() {
		$('.sign-up').show();
		$('.sign-in').hide();
		$('.forgot').hide();
	});
	$('.btn-cancel').click( function() {
		$('.sign-up').hide();
		$('.forgot').hide();
		$('.sign-in').show();
	});
	$('.btn-forgot').click( function() {
		$('.sign-up').hide();
		$('.sign-in').hide();
		$('.forgot').show();
	});

	
@stop

@section('script_plugin')
	@include('plugins.input-mask')
@stop