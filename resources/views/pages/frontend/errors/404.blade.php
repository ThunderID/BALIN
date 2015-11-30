@extends('template.frontend.layout')
@section('content')
	<div class="container ">
		<div class="row error-responsive">
			<div class="col-md-6 col-md-offset-3 text-center">
				<h1>
				404
				</h1>
				<h3 style="margin-top:0px;">
				Maaf halaman yang Anda tuju tidak tersedia
				</h3>
				</br>
				<a href="{{route('frontend.home.index')}}"class="btn btn-block btn-hollow hollow-black-border">
				Home
				</a>
			</div>
		</div>
	</div>
@stop