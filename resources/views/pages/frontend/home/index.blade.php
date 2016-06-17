@extends('template.frontend.layout')


@section('content')
{{-- Desktop and Tablet Section --}}
	<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs p-t-none p-l-none p-r-none p-b-none">
		<div class="container m-t-sm p-b-xl">
			<div class="row">
				<div class="col-md-12 col-sm-12 p-t-xl">
					<div class="col-md-6 col-sm-6 p-r-md">
						<div class="row">
							<div class="col-md-12 p-t-sm p-l-lg" style="height: 400px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-woman.jpg') }}');">
								<div class="col-md-4 col-sm-6">
									<h2 class="heading text-left p-t-sm p-b-sm">
										Woman Collection
									</h2>
									<a href="#" class="btn-hollow hollow-black-border">Lihat Koleksi</a>
								</div>
								<div class="col-md-8 col-sm-6">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 p-l-md">
						<div class="row">
							<div class="col-md-12 p-t-sm p-r-lg" style="height: 400px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-man.jpg') }}');">
								<div class="col-md-8 col-sm-6">
								</div>
								<div class="col-md-4 col-sm-6">
									<h2 class="heading text-right p-t-sm p-b-sm">Man Collection</h2>
									<a href="#" class="btn-hollow hollow-black-border pull-right">Lihat Koleksi</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 p-t-md">
						<div class="row" style="height: 225px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-new.png') }}');">
							<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12 p-t-xl text-center slide-bottom"  data-plugin-options='{"reverse":false}'>
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
		</div>

		<div class="container m-t-md m-r-none m-l-none" style="background-color:#fff; width:100%;">
			
			<div class="container">

				<div class="row p-t-md">
					<div class="col-md-12 col-sm-12 text-center">
						<h2 class="slide-left" data-plugin-options='{"reverse":false}'>Produk Terbaik Dari Kami</h2>

						<div class="slide-right" data-plugin-options='{"reverse":false}'>
							<a href="#batik_woman" class="home-tab t-sm" aria-controls="batik_woman" role="tab" data-toggle="tab" data-tab-id="batik_woman">Batik Wanita</a>
							&nbsp;|&nbsp;
							<a href="#all" class="home-tab t-sm home-tab-active" aria-controls="all" role="tab" data-toggle="tab" data-tab-id="all">Semua Produk</a>
							&nbsp;|&nbsp;
							<a href="#batik_man" class="home-tab t-sm" aria-controls="batik_man" role="tab" data-toggle="tab" data-tab-id="batik_man">Batik Pria</a>
						</div>
					</div>
				</div>	

				<div class="tab-content m-t-lg m-b-xl">
					<div role="tabpanel" class="tab-pane in" id="batik_woman">
						<div class="row">
							@foreach($datas['batik_wanita'] as $key => $data)
								@if($key == (count($datas['batik_wanita']) - 1))
									<div class="hidden-sm col-md-3 card-animate">
										@include('widgets.product_card_no_label')
									</div>
								@else
									<div class="col-sm-4 col-md-3 card-animate">
										@include('widgets.product_card_no_label')
									</div>
								@endif
							@endforeach
						</div>
						<div class="row slide-bottom" data-plugin-options='{"offset":40 ,"distance":10}'>
							<div class="col-md-12 col-sm-12">
								<div class="col-md-12 col-sm-12 col-xs-12 p-t-xl m-b-sm text-center" style="height: 150px; background-color:#FFF;">
									<h2 class="heading m-t-none">Suka Produk Kami? </h2>
									<a href="#" class="btn-hollow hollow-black-border">Lihat Semua Koleksi</a>
								</div>
							</div>					
						</div>				
					</div>

					<div role="tabpanel" class="tab-pane in active" id="all">
						<div class="row">
							@foreach($datas['all'] as $key => $data)
								@if($key == (count($datas['all']) - 1))
									<div class="hidden-sm col-md-3 card-animate">
										@include('widgets.product_card_no_label')
									</div>
								@else
									<div class="col-sm-4 col-md-3 card-animate">
										@include('widgets.product_card_no_label')
									</div>
								@endif
							@endforeach
						</div>
						<div class="row slide-bottom" data-plugin-options='{"offset":40 ,"distance":10}'>
							<div class="col-md-12 col-sm-12">
								<div class="col-md-12 col-sm-12 col-xs-12 p-t-xl m-b-sm text-center" style="height: 150px; background-color:#FFF;">
									<h2 class="heading m-t-none">Suka Produk Kami? </h2>
									<a href="#" class="btn-hollow hollow-black-border">Lihat Semua Koleksi</a>
								</div>
							</div>					
						</div>
					</div>

					<div role="tabpanel" class="tab-pane in" id="batik_man">
						<div class="row">
							@foreach($datas['batik_pria'] as $key => $data)
								@if($key == (count($datas['batik_pria']) - 1))
									<div class="hidden-sm col-md-3 card-animate">
										@include('widgets.product_card_no_label')
									</div>
								@else
									<div class="col-sm-4 col-md-3 card-animate">
										@include('widgets.product_card_no_label')
									</div>
								@endif
							@endforeach
						</div>
						<div class="row slide-bottom" data-plugin-options='{"offset":40 ,"distance":10}'>
							<div class="col-md-12 col-sm-12">
								<div class="col-md-12 col-sm-12 col-xs-12 p-t-xl m-b-sm text-center" style="height: 150px; background-color:#FFF;">
									<h2 class="heading m-t-none">Suka Produk Kami? </h2>
									<a href="#" class="btn-hollow hollow-black-border">Lihat Semua Koleksi</a>
								</div>
							</div>					
						</div>				
					</div>
				</div>
			</div>
		</div>	
	</div>	

{{-- Mobile --}}
	<div class="hidden-lg hidden-md hidden-sm col-xs-12 p-t-none p-l-none p-r-none p-b-none">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 p-t-sm p-l-lg" style="height: 300px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-woman.jpg') }}');">
					<h2 class="heading text-left p-t-sm p-b-none">Woman</h2>
					<h2 class="heading text-left m-t-none p-b-sm">Collection</h2>
					<a href="#" class="btn-hollow hollow-black-border">Lihat Koleksi</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 p-t-sm p-r-lg" style="height: 300px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-man.jpg') }}');">
					<h2 class="heading text-right p-t-sm p-b-none">Man</h2>
					<h2 class="heading text-right m-t-none p-b-sm">Collection</h2>
					<a href="#" class="btn-hollow hollow-black-border pull-right">Lihat Koleksi</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12" style="height: 275px; background-size:cover; background-image: url('{{ asset('Balin/web/image/asset-new.png') }}');">
					<div class="row">
						<div class="col-xs-12 m-t-md p-t-xl text-center">
							<h4 class="heading slide-left" data-plugin-options='{"distance":5, "reverse": false}'>
								<span style="background: rgba(255,255,255,0.7);">
									&nbsp;Memperkenalkan Produk Terbaru Kami&nbsp;
								</span>
							</h4>
							<h2 class="heading m-t-md p-b-md slide-right" data-plugin-options='{"distance":5, "reverse": false}'>
								<span style="background: rgba(255,255,255,0.7);">
									&nbsp;Balin Shoes&nbsp;
								</span>
							</h2>
							<a href="#" class="btn-hollow hollow-black-border text-center btn-pre-top">Woman Collection</a>
							<a href="#" class="btn-hollow hollow-black-border text-center">Man Collection</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container m-r-none m-l-none" style="background-color:#fff; width:100%;">
			<div class="container">

				<div class="row p-t-xl">
					<div class="col-md-12 col-sm-12 text-center">

						<div class="p-b-sm">
							<div class="slide-top p-t-md" data-plugin-options='{"distance":20, "reverse": false}'>
								<a href="#m_all" class="home-tab t-sm home-tab-active" aria-controls="all" role="tab" data-toggle="tab" data-tab-id="all">SEMUA PRODUK</a>
							</div>
							<div class="slide-top p-t-md" data-plugin-options='{"distance":20, "reverse": false}'>
								<a href="#m_batik_woman" class="home-tab t-sm" aria-controls="batik_woman" role="tab" data-toggle="tab" data-tab-id="batik_woman">BATIK WANITA</a>
							</div>
							<div class="slide-top p-t-md" data-plugin-options='{"distance":20, "reverse": false}'>
								<a href="#m_batik_man" class="home-tab t-sm" aria-controls="batik_man" role="tab" data-toggle="tab" data-tab-id="batik_man">BATIK PRIA</a>
							</div>
						</div>

					</div>
				</div>
				<div class="row">
					<div class="tab-content m-t-lg m-b-xl">

						<div role="tabpanel" class="tab-pane in" id="m_batik_woman">
							<div class="row">
								@foreach($datas['batik_wanita'] as $key => $data)
									@if($key < (count($datas['batik_wanita']) - 1))
										<div class="col-xs-12">
											@include('widgets.product_card_no_label')
										</div>
									@endif
								@endforeach
							</div>
							<div class="row slide-bottom" data-plugin-options='{"offset":20 ,"distance":20, "reverse":false}'>
								<div class="col-xs-12">
									<div class="col-xs-12 p-t-xl m-b-sm text-center" style="height: 150px; background-color:#FFF;">
										<h2 class="heading m-t-none">Suka Produk Kami? </h2>
										<a href="#" class="btn-hollow hollow-black-border">Lihat Semua Koleksi</a>
									</div>
								</div>					
							</div>				
						</div>

						<div role="tabpanel" class="tab-pane in active" id="m_all">
							<div class="row">
								@foreach($datas['all'] as $key => $data)
									@if($key < (count($datas['all']) - 1))
										<div class="col-xs-12">
											@include('widgets.product_card_no_label')
										</div>
									@endif
								@endforeach
							</div>
							<div class="row slide-bottom" data-plugin-options='{"offset":20 ,"distance":20, "reverse":false}'>
								<div class="col-xs-12">
									<div class="col-xs-12 p-t-xl m-b-sm text-center" style="height: 150px; background-color:#FFF;">
										<h2 class="heading m-t-none">Suka Produk Kami? </h2>
										<a href="#" class="btn-hollow hollow-black-border">Lihat Semua Koleksi</a>
									</div>
								</div>					
							</div>
						</div>

						<div role="tabpanel" class="tab-pane in" id="m_batik_man">
							<div class="row">
								@foreach($datas['batik_pria'] as $key => $data)
									@if($key < (count($datas['batik_pria']) - 1))
										<div class="col-xs-12">
											@include('widgets.product_card_no_label')
										</div>
									@endif
								@endforeach
							</div>
							<div class="row slide-bottom" data-plugin-options='{"offset":20 ,"distance":20, "reverse":false}'>
								<div class="col-xs-12">
									<div class="col-xs-12 p-t-xl m-b-sm text-center" style="height: 150px; background-color:#FFF;">
										<h2 class="heading m-t-none">Suka Produk Kami? </h2>
										<a href="#" class="btn-hollow hollow-black-border">Lihat Semua Koleksi</a>
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

@section('script_plugin')
	@include('plugins.fadeThis')
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
