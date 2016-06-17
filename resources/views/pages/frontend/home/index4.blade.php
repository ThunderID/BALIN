@extends('template.frontend.layout')


@section('content')
	<div class="container m-t-sm">
		<div class="row">
			<div class="col-md-12 col-sm-12 p-t-xl">

				{{-- Desktop and Tablet Section --}}
				<div class="col-md-6 col-sm-6 hidden-xs p-r-md">
					<div class="row">
						<div class="col-md-12 p-t-md p-l-lg" style="height: 400px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-woman.jpg') }}');">
							<h2 class="heading text-left p-b-sm">Woman Section</h2>
							<a href="#" class="btn-hollow hollow-black-border">View Collection</a>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 hidden-xs p-l-md">
					<div class="row">
						<div class="col-md-12 p-t-md p-r-lg" style="height: 400px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-man.jpg') }}');">
							<h2 class="heading text-right p-b-sm">Man Section</h2>
							<a href="#" class="btn-hollow hollow-black-border pull-right">View Collection</a>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 hidden-xs p-t-md">
					<div class="row" style="height: 225px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-new.png') }}');">
						<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12 p-t-xl text-center">
							<h4 class="heading">Memperkenalkan Produk Terbaru Kami</h4>
							<h2 class="heading m-t-none p-b-md">Balin Shoes</h2>
							<a href="#" class="btn-hollow hollow-black-border text-center">Woman Collection</a>
							&nbsp;
							<a href="#" class="btn-hollow hollow-black-border text-center">Man Collection</a>
						</div>
					</div>
				</div>				

			</div>
		</div>

		<div class="row m-t-xl">
			<div class="col-md-12 col-sm-12 text-center">
				<h2>Produk Terbaik Dari Kami</h2>

				<a href="#batik_woman" class="home-tab" aria-controls="batik_woman" role="tab" data-toggle="tab" data-tab-id="batik_woman">Batik Wanita</a>
				&nbsp;
				<a href="#all" class="home-tab home-tab-active" aria-controls="all" role="tab" data-toggle="tab" data-tab-id="all">Semua Produk</a>
				&nbsp;
				<a href="#batik_man" class="home-tab" aria-controls="batik_man" role="tab" data-toggle="tab" data-tab-id="batik_man">Batik Pria</a>
			</div>
		</div>	

		<div class="tab-content m-t-lg m-b-xl">
			<div role="tabpanel" class="tab-pane in" id="batik_woman">
				<div class="row">
					@foreach($datas['batik_wanita'] as $data)
						<div class="col-sm-4 col-md-3 card-animate">
							@include('widgets.product_card')
						</div>
					@endforeach
				</div>
				<div class="row card-animate">
					<div class="col-md-12 col-sm-12">
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-md text-center" style="height: 150px; background-color:#FFF;">
							<h4 class="heading"><!-- Memperkenalkan Produk Terbaru Kami --></h4>
							<h2 class="heading m-t-none">Suka Produk Kami? </h2>
							<a href="#" class="btn-hollow hollow-black-border">View Collection</a>
						</div>
					</div>					
				</div>				
			</div>

			<div role="tabpanel" class="tab-pane in active" id="all">
				<div class="row">
					@foreach($datas['all'] as $data)
						<div class="col-sm-4 col-md-3 card-animate">
							@include('widgets.product_card')
						</div>
					@endforeach
				</div>
				<div class="row card-animate">
					<div class="col-md-12 col-sm-12">
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-md text-center" style="height: 150px; background-color:#FFF;">
							<h4 class="heading"><!-- Memperkenalkan Produk Terbaru Kami --></h4>
							<h2 class="heading m-t-none">Suka Produk Kami? </h2>
							<a href="#" class="btn-hollow hollow-black-border">View Collection</a>
						</div>
					</div>					
				</div>
			</div>

			<div role="tabpanel" class="tab-pane in" id="batik_man">
				<div class="row">
					@foreach($datas['batik_pria'] as $data)
						<div class="col-sm-4 col-md-3 card-animate">
							@include('widgets.product_card')
						</div>
					@endforeach
				</div>
				<div class="row card-animate">
					<div class="col-md-12 col-sm-12">
						<div class="col-md-12 col-sm-12 col-xs-12 p-t-md text-center" style="height: 150px; background-color:#FFF;">
							<h4 class="heading"><!-- Memperkenalkan Produk Terbaru Kami --></h4>
							<h2 class="heading m-t-none">Suka Produk Kami? </h2>
							<a href="#" class="btn-hollow hollow-black-border">View Collection</a>
						</div>
					</div>					
				</div>				
			</div>
		</div>

	</div>	
@stop

@section('script')
	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
		$('.home-tab').removeClass('home-tab-active');
		$(this).addClass('home-tab-active');

		animateCard($(this).data('tab-id'));
	})

	function animateCard(e){
		var delay = 0;

		$('#' + e).find('.card-animate').css('opacity',0);
		$('#' + e).find('.card-animate').each(function() {
		    $(this).delay(delay).animate({
		        opacity:1
		    },750);
		    delay += 250;
		});
	};  
@stop
