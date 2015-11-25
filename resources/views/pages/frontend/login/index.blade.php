@inject('store', 'App\Models\StoreSetting')

<?php 
	$stores			= $store->type('why_join')->Ondate('now')->first();
	$tc 			= $store->type('term_and_condition')->ondate('now')->orderby('started_at', 'desc')->first();
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container-fluid page-join">
		<div class="row mt-75 mobile-m-t-25" style="padding-top:20px">
			<div class="col-md-12">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-5 col-xs-12 hidden-xs">
									 <div class="row">
										<div class="col-md-12">
											{!! $stores['value'] !!}
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

		<div id="tnc" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">Term & Condition</h4>
					</div>
					<div class="modal-body ribbon-menu">
						<div class="row">
							<div class="col-md-12">
								{!! $tc['value'] !!}
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
						<div class="row">
							<div class="col-md-12 text-left">
								<button type="button" class="btn-hollow hollow-black-border" data-dismiss="modal" aria-label="Close">Tutup</button>
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
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

	function setModalMaxHeight(element) {
		this.$element     = $(element);
		var dialogMargin  = $(window).width() > 767 ? 62 : 22;
		var contentHeight = $(window).height() - dialogMargin;
		var headerHeight  = this.$element.find('.modal-header').outerHeight() || 2;
		var footerHeight  = this.$element.find('.modal-footer').outerHeight() || 2;
		var maxHeight     = contentHeight - (headerHeight + footerHeight);

		this.$element.find('.modal-content').css({
			'overflow': 'hidden'
		});

		this.$element.find('.modal-body').css({
			'max-height': maxHeight,
			'overflow-y': 'auto'
		});
	}

	$('.modal').on('show.bs.modal', function() {
		$(this).show();
		setModalMaxHeight(this);
	});

	$(window).resize(function() {
		if ($('.modal.in').length != 0) {
			setModalMaxHeight($('.modal.in'));
		}
	});
@stop

@section('script_plugin')
	@include('plugins.input-mask')
@stop