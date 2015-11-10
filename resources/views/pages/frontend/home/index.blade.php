@extends('template.frontend.layout')

@section('content')
	<!-- Full Page Image Background Carousel Header -->

	<section id="my-carousel" class="carousel slide hidden-xs hide">
		@include('widgets.slider')
	</section>
	<div class="hidden-xs">
		@include('widgets.slider-revolution')
	</div>
	
	<section class="container-fluid">
		<div class="row hidden-sm hidden-md hidden-lg">
			<div class="col-xs-12 p-l-none p-r-none">
				<img src="Balin/web/image/1.jpg" style="" class="img-responsive">
			</div>
			<div class="col-xs-12 p-l-none p-r-none">
				<img src="Balin/web/image/2.jpg" style="" class="img-responsive">
			</div>
			<div class="col-xs-12 p-l-none p-r-none">
				<img src="Balin/web/image/3.jpg" style="" class="img-responsive">
			</div>
		</div>
	</section>

	<!-- <section id="why-join" class="p-t">
		@include('pages.frontend.why_join.partial_why_join')
	</section>

	@if (!Auth::user())
		<section id="sign-in" class="p-t" style="background-image: url('http://localhost:8000/Balin/web/image/2.jpg')">
			@include('pages.frontend.login.partial_login')
		</section>
	@endif

	<section id="about-us" class="p-t">
		@include('pages.frontend.about_us.partial_about_us')
	</section>

	<section id="contact-us" class="p-t">
		@include('pages.frontend.contact_us.partial_contact_us')
	</section> -->
@stop

@section('script')
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
	@include('plugins.revolution-slider')
@stop