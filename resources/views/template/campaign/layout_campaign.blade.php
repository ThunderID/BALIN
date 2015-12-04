@extends('template.layout')

@section('content_layout')
	<!DOCTYPE html>
	<html lang="en" style="">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
	   {!! HTML::style('Balin/web/plugin/fontawesome/css/font-awesome.min.css') !!}
	   {!! HTML::style('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700') !!}

	   <link rel="shortcut icon" href="{{ url('Balin/web/image/favicon.ico') }} "/>
	</head>
	<body style="
		background: url('Balin/web/image/bg.jpg') no-repeat;
		background-position: center center;
		-moz-background-size: cover;
	    -webkit-background-size: cover;
	    -o-background-size: cover;
	    background-size: cover;">
		<div class="container" id="container">
			@yield('content')
		</div>

		<!-- jQuery -->
		{!! HTML::script('Balin/web/js/jquery.js') !!}
		{!! HTML::script('Balin/web/js/bootstrap.min.js') !!}

		<script>
			@yield('script')
		</script>
		@yield('script_plugin')
	</body>
	</html>
@stop
