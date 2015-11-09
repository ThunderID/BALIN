@extends('template.frontend.layout')

@section('content')
	<div class="container-fluid page-join" style="background-color: rgba(0, 0, 0, 0.62);">
		<div class="container">
			<div class="row" style="padding-top:60px">
				<div class="col-md-4 col-md-offset-4">
					<div class="row panel-hollow panel-default p-xs" style="margin-top:28%">
						<div class="col-md-12">
							<p>Point anda berhasil di claim.</p>
							<p>Silahkan Login untuk mengecek buku tabungan anda.</p>
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