@extends('template.frontend.layout')

@section('content')
	<!-- Full Page Image Background Carousel Header -->

	{{-- <section id="my-carousel" class="carousel slide hidden-xs hide">
		@include('widgets.slider')
	</section> --}}
	<div class="hidden-xs">
		@include('widgets.slider-revolution')
	</div>
	
	<section class="container-fluid">
		<div class="row hidden-sm hidden-md hidden-lg">
			<div class="col-xs-12 p-l-none p-r-none m-t-lg" style="position:relative">
				<div class="caption-mobile right">
					<h3 class="m-r-md">PRODUK BATIK UNGGULAN<br>DAERAH MALANG</h3>
					<p class="m-t-sm m-r-md">BATIK BERKUALITAS BAGUS <br>DAN BUKAN BATIK BIASA</p>
					<p class="m-r-md">DESAIN SIMPLE...<br>MINIMALIS...ELEGAN...</p>
					<a href="#" class="btn-hollow hollow-black btn-hollow-xs m-r-md">LIHAT PRODUK KAMI</a>
				</div>
				<img src="Balin/web/image/slide-2.png" style="" class="img-responsive">
			</div>
			<div class="col-xs-12 p-l-none p-r-none" style="position:relative">
				<div class="caption-mobile left">
					<h3 class="m-l-md">PRODUK TERLARIS KAMI</h3>
					<p class="m-t-sm m-l-md">BERSERAT RAPAT <br>DAN TIDAK MUDAH PANAS</p>
					<p class="m-l-md">SANGAT LEMBUT DAN HALUS</p>
					<p class="m-l-md">COCOK DIPAKAI SEHARI-HARI </p>
					<a href="#" class="btn-hollow hollow-black btn-hollow-xs m-l-md">TAMBAHKAN DIKERANJANG</a>
				</div>
				<img src="Balin/web/image/slide-1.png" style="" class="img-responsive">
			</div>
			<div class="col-xs-12 p-l-none p-r-none" style="position:relative">
				<div class="caption-mobile right">
					<p class="m-t-sm m-r-md">BATIK TULIS</p>
					<p class="m-r-md">BATIK CAP</p>
					<p class="m-r-md">BATIK PRINTING</p>
					<p class="m-r-md">BATIK PREMIUM</p>
				</div>
				<img src="Balin/web/image/slide-3.png" style="" class="img-responsive">
			</div>
			<div class="col-xs-12 p-l-none p-r-none" style="position:relative">
				<div class="caption-mobile left">
					<p class="m-t-sm m-l-md">BATIK TULIS</p>
					<p class="m-l-md">BATIK CAP</p>
					<p class="m-l-md">BATIK PRINTING</p>
					<p class="m-l-md">BATIK PREMIUM</p>
				</div>
				<img src="Balin/web/image/slide-4.png" style="" class="img-responsive">
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