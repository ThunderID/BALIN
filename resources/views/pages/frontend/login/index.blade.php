@extends('template.frontend.layout')

@section('content')
	<div class="container-fluid page-join">
		<div class="row mt-75" style="padding-top:20px">
			<div class="col-md-12">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-5 col-xs-12 hidden-xs">
									 <div class="row">
										<div class="col-md-12">
											<div class="info-corporate">
												<p class="t-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus iure ratione maiores ducimus nulla cumque qui voluptatem dolores distinctio odit? Dolore praesentium officia distinctio itaque corporis quidem quod officiis iste.</p>

												<p class="t-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus iure ratione maiores ducimus nulla cumque qui voluptatem dolores distinctio odit? Dolore praesentium officia distinctio itaque corporis quidem quod officiis iste.</p>

												<p class="t-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus iure ratione maiores ducimus nulla cumque qui voluptatem dolores distinctio odit? Dolore praesentium officia distinctio itaque corporis quidem quod officiis iste.</p>
											</div>
										</div>
									</div>
									<div class="clearfix">&nbsp;</div>
								</div>
								<div class="col-md-5 col-xs-12 col-md-offset-2">
									<div class="row panel-hollow panel-default p-xs m-t-n-xs">
										<div class="col-md-12">
											<div class="sign-in">
												<h3>Sign In</h3>
												@include('widgets.login')
											</div>
											<div class="sign-up" style="display:none">
												<h3>Sign Up</h3>
												<div class="clearfix">&nbsp;</div>
												@include('widgets.alerts')
												@include('widgets.signup')
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