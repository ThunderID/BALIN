@extends('template.frontend.layout_onepage')

@section('content')
	<!-- Full Page Image Background Carousel Header -->
	<section id="intro">
		<div id="my-carousel" class="carousel slide">
			@include('widgets.slider')
		</div>
	</section>

	<section id="why-join" class="p-t">
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
	</section>
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