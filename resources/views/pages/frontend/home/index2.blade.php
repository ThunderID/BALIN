@extends('template.frontend.layout')


@section('content')
	<div class="col-md-12 col-sm-12 p-l-none p-r-none p-b-lg">

		{{-- Desktop and Tablet Section --}}
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row">
				<div class="col-md-12 p-t-md" style="height: 400px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-woman.jpg') }}');">
					<!-- <h4 class="heading text-left">Women</h4> -->
					<h2 class="heading text-left p-b-sm">Woman Section</h2>
					<!-- <h3 class="heading text-left">Get a 30% Discount</h3> -->
					<a href="#" class="btn-hollow hollow-black-border">View Collection</a>
				</div>
				<!-- <img class="img-responsive pull-right" alt="" src=""> -->
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row">
				<div class="col-md-12 p-t-md p-r-lg" style="height: 400px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-man.jpg') }}');">
					<!-- <h4 class="heading text-right">Man</h4> -->
					<h2 class="heading text-right p-b-sm">Man Section</h2>
					<!-- <h3 class="heading text-right">Get a 30% Discount</h3> -->
					<a href="#" class="btn-hollow hollow-black-border pull-right">View Collection</a>
				</div>
				<!-- <img class="img-responsive pull-left" alt="" src="img/coats-jackets.jpg"> -->
			</div>
		</div>
	</div>

	<div class="container m-t-lg">
		<div class="row m-t-xl">
			<div class="col-md-12 col-sm-12 text-center">
				<h2>Produk Terbaik Dari Kami</h2>

				<a href="#batik_woman" class="home-tab" aria-controls="batik_woman" role="tab" data-toggle="tab">Batik Wanita</a>
				&nbsp;
				<a href="#latest" class="home-tab home-tab-active" aria-controls="latest" role="tab" data-toggle="tab">Produk Terbaru</a>
				&nbsp;
				<a href="#batik_man" class="home-tab" aria-controls="batik_man" role="tab" data-toggle="tab">Batik Pria</a>
			</div>
		</div>	

		<div class="tab-content m-t-lg m-b-xl">
			<div role="tabpanel" class="tab-pane fade in" id="batik_woman">
				<div class="row">
					@foreach($datas as $data)
						<div class="col-sm-4 col-md-3">
							@include('widgets.product_card')
						</div>
					@endforeach
				</div>
			</div>

			<div role="tabpanel" class="tab-pane fade in active" id="latest">
				<div class="row">
					@foreach($datas as $data)
						<div class="col-sm-4 col-md-3">
							@include('widgets.product_card')
						</div>
					@endforeach
				</div>
			</div>

			<div role="tabpanel" class="tab-pane fade in" id="batik_man">
				<div class="row">
					@foreach($datas as $data)
						<div class="col-sm-4 col-md-3">
							@include('widgets.product_card')
						</div>
					@endforeach
				</div>
			</div>
		</div>

	</div>	
@stop

@section('script')
	$('.home-tab').click( function() {
		$('.home-tab').removeClass('home-tab-active');
		$(this).addClass('home-tab-active');
	});

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
