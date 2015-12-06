@extends('template.layout')

@section('content_layout')
<!DOCTYPE html>
<html lang="en">

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

	<style>
		.text-product.small-price {
			font-size: 10pt !important;
		}  

		.text-white {
			color:#888;
			font-size: 13px;
		}

		.hollow-active a{
			background-color: black !important;
			color: #aaa !important;
		}

		.hollow-active a:hover{
			color: white !important;
		}

		.circle-label.black:after{
			background: #333 !important;
		}		

		.hover-none a:hover{
			text-decoration: none;
		}

		.tag-sale {
			position: absolute;
		    bottom: 0;
		    width: 100%;
		    background-color: rgba(117, 170, 219, 0.81);
		    color: #fff;
		    text-align: center;
		    padding: 15px;
		    line-height: 16px;
		    font-size: 16px;
		}
		.tag-sale p {
			margin-bottom: 0;
		    font-weight: 500;
		    letter-spacing: 0.2em;
		}
		.tag-info {
			background-color: rgba(0, 0, 0, 0.7);
			position: absolute;
			top: 0;
			padding-left: 8px;
			padding-right: 8px;
		}
		.tag-info p{
		    margin-bottom: 0;
		    color: #fff;
		    font-size: 15px;
		    letter-spacing: 0.02em;
		}


	</style>

	<!-- Custom CSS -->
   {!! HTML::style('Balin/web/css/bootstrap.min.css') !!}
   {!! HTML::style('Balin/web/css/layout.css') !!}
   <link rel="stylesheet" href="{{ elixir('Balin/web/css/style-web.css') }}">
   {!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css') !!}
   {!! HTML::style('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700') !!}

   <link rel="shortcut icon" href="{{ url('Balin/web/image/favicon.ico') }} "/>

</head>

<body>
	@if($controller_name == 'home') <?php $pb = 0; ?>@endif
	
	<div id="container" @if(Route::is('frontend.join.index')) class="bg-ground" @endif>

		<header class="page-header" @if($controller_name == 'home') style="margin:0" @endif>
			@include('widgets.top_menu')
		</header>

		@yield('content')

	</div>

	@if ($controller_name != 'home')
		<div class="container"></div>
		<!-- <div id="footer"></div> -->
		@include('widgets.footer')
	@endif

	<!-- /.container -->

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<script>
	@yield('script')

	@include('widgets.scripts.inputNumberValidator')

	$('ul.nav li.dropdown').hover(function() {        
		$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(300);
	}, function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
	});

	</script>
	@yield('script_plugin')
</body>

</html>
@stop
