@extends('template.frontend.layout')

@section('content')
	<div class="container-fluid page-join" style="background-color: rgba(0, 0, 0, 0.62);">
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
	</div>
@stop

@section('script')
	$('document').ready(function() {
		$('body').attr('style', 'background-image: url("http://localhost:8000/Balin/web/image/2.jpg")');
		$('.page-join').height(($(window).height())+$('footer.footer').height());
	});
@stop