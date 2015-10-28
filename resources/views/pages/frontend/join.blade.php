@extends('template.frontend.layout')

@section('content')
	<div class="container-fluid page-join" style="background-color: rgba(0, 0, 0, 0.62);height:100%">
		<div class="row" style="margin-top:60px">
			<div class="col-md-12">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-5 col-xs-12">
									 <div class="row">
										<div class="col-md-12">
											<div class="info-corporate">
												{!! HTML::image('Balin/admin/image/logo.png') !!}
												<div class="clearfix">&nbsp;</div>
												<div class="clearfix">&nbsp;</div>
												<p class="t-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus iure ratione maiores ducimus nulla cumque qui voluptatem dolores distinctio odit? Dolore praesentium officia distinctio itaque corporis quidem quod officiis iste.</p>

												<p class="t-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus iure ratione maiores ducimus nulla cumque qui voluptatem dolores distinctio odit? Dolore praesentium officia distinctio itaque corporis quidem quod officiis iste.</p>

												<p class="t-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus iure ratione maiores ducimus nulla cumque qui voluptatem dolores distinctio odit? Dolore praesentium officia distinctio itaque corporis quidem quod officiis iste.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-5 col-xs-12 col-md-offset-2">
									<div class="row panel-hollow panel-default p-xs">
										<div class="col-md-12">
											<div class="sign-in">
												<h3>Sign In</h3>
												<div class="clearfix">&nbsp;</div>
												@include('widgets.login')
											</div>
											<div class="sign-up" style="display:none">
												<h3>Sign Up</h3>
												<div class="clearfix">&nbsp;</div>
												@include('widgets.signup')
											</div>
										</div>	
									</div>                        
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
	$('document').ready(function() {
		$('body').attr('style', 'background-image: url("http://localhost:8000/Balin/web/Image/2.jpg")');
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
	});
@stop