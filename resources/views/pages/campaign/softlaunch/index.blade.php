@inject('store', 'App\Models\StoreSetting')
<?php 
	$tc 			= $store->type('term_and_condition')->ondate('now')->orderby('started_at', 'desc')->first();
?>

@extends('template.campaign.layout_campaign')
@section('content')
	<div class="container-fluid softlaunch-sign-up" style="">
		<div class="row">
			<div class="col-xs-12 col-sm-5 col-sm-offset-7 col-md-5 col-md-offset-7 col-lg-5 col-lg-offset-7">
				<?php
				function isMobile() {
				    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
				}
				?>	

				<div class="form-softlaunch p-sm" style="margin-top: 10%;">
					<h3 class="m-t-xs">Early Sign Up</h3>
					{!! Form::open(['url' => route('frontend.early.post')]) !!}
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
					<div class="row m-b-sm">
						<div class="col-md-12 text-center">
							<button type="button" class="btn-hollow hollow-black-border" data-dismiss="modal" aria-label="Close">Tutup</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
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