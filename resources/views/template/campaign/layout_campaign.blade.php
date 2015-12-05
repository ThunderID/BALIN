@extends('template.layout')

@section('content_layout')
	<!DOCTYPE html>
	<html lang="en" style="">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">

		@if(isset($page_subtitle))
			<title>{{$page_subtitle}} - {{$page_title}}</title>
		@else
		<title>BALIN.ID</title>
		@endif
		@if(isset($metas))
			@foreach ($metas as $k => $v)
				<meta name="{{$k}}" content="{{strip_tags($v)}}">
			@endforeach
		@endif

		<!-- Custom CSS -->
	   {!! HTML::style('Balin/web/css/bootstrap.min.css') !!}
	   {!! HTML::style('Balin/web/css/layout.css') !!}
	   <link rel="stylesheet" href="{{ elixir('Balin/web/css/style-web.css') }}">
	   {!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css') !!}
	   {!! HTML::style('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700') !!}

	   <link rel="shortcut icon" href="{{ url('Balin/web/image/favicon.ico') }} "/>
	   <style type="text/css">
	   		body {
				background: url('../../../../Balin/web/image/bg.jpg') no-repeat;
				background-position: 80% 50%;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
	   		}

	   		@media (min-width: 768px) and (max-width: 992px) {
	   			body {
					background-position: 30% 50%;
	   			}
	   		}

	   		@media (max-width: 767px) {
	   			body {
					background-position: 15% 50%;
	   			}
	   		}
	   </style>
	</head>
	<body>
		<div class="container" id="container">
			@yield('content')
		</div>

		<!-- jQuery -->
		{!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js') !!}
		{!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js') !!}

		<script>
			@yield('script')
		</script>
		@yield('script_plugin')
	</body>
	</html>
@stop
