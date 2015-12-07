@extends('template.frontend.layout')

@section('content')
	<div class="container-fluid page-join" style="">
		<div class="row mt-75 mobile-m-t-25" style="">
			<div class="col-md-12">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-5 col-xs-12 col-md-offset-7">
									<div class="row panel-hollow panel-default p-xs m-t-n-xs">
										<div class="col-md-12">
											<div class="col-md-12 text-center">
												<h3 class="">Selamat!</h3> 
												<p class="m-b-sm m-t-md">Anda mendapatkan Balin Point senilai</p> 
												<h3 class="m-b-md">@money_indo($amount)</h3>
												@if(Auth::check())
													<p>Cek buku tabungan anda sekarang juga.</p>
													<a href="{{ URL::route('frontend.user.point') }}" class="btn-hollow hollow-black hollow-black-border" tabindex="6">Buku Tabungan</a>
												@else
													<a href="{{ URL::route('frontend.join.index') }}" class="btn-hollow hollow-black hollow-black-border" tabindex="6">SIGN IN NOW</a>
												@endif
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
	</div>
	<!-- <div class="container-fluid page-join">

		<div class="container">
			<div class="row" style="padding-top:60px">
				<div class="col-md-6 col-md-offset-3">
					<div class="row panel-hollow panel-default p-xs">
						<div class="col-md-12 text-center">
							<h5>Point anda berhasil di claim.</h5>
						<div class="col-md-12 text-center">
							<img class="img img-responsive text-center" style="margin: 0 auto" src="http://lineofficial.blogimg.jp/en/imgs/2/b/2ba1b44b.png" alt="">
						</div>
						<div class="col-md-12 text-center">
							@if(Auth::check())
								<p>Cek buku tabungan anda sekarang juga.</p>
								<a href="{{ URL::route('frontend.user.point') }}" class="btn-hollow hollow-black hollow-black-border" tabindex="6">Buku Tabungan</a>
							@else
								<p>Silahkan Sign in untuk mengecek buku tabungan anda.</p>
								<a href="{{ URL::route('frontend.join.index') }}" class="btn-hollow hollow-black hollow-black-border" tabindex="6">Sign In</a>
							@endif
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div> -->
@stop

@section('script')
	$('document').ready(function() {
		$('.page-join').height(($(window).height())+$('footer.footer').height());
	});
@stop