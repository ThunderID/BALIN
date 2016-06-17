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

		.home-tab{
			color: #777 !important;
		}

		.home-tab-active{
			color: black !important;
			border-bottom: black 1px solid !important;
			pointer-events: none;
		    cursor: default;
		}

		@media screen and (max-width: 304px) {
			.btn-pre-top{
				margin-top: -30px;		
			}	

			.hidden-xxs{
				display: none !important;
			}			
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
	
	<div id="container" @if(Route::is('frontend.join.index')||Route::is('balin.claim.voucher')) class="bg-ground" @endif>

		<header class="page-header">
			@include('widgets.top_menu')
		</header>

		@yield('content')

		<div class="navbar navbar-default navbar-fixed-bottom hidden-lg hidden-md hidden-sm col-xs-12" role="navigation" style="border-top: solid 2px #ddd">
			<div class="nav navbar-nav text-center" style="margin-top:0px !important; margin-bottom:0px !important;">
				<div onclick="location.href='{{ URL::route('frontend.home.index') }}';" class="col-xs-{{(Auth::user())?"3":"4"}} text-center" style="border-right:1px solid #ddd; height:75px; padding-top: 8px; padding-bottom: 8px;">
					{!! HTML::image('Balin/web/image/home.png', 'image' ,['style' => 'padding-top:6px; padding-bottom:6px; height:37px; width:25px; margin: 0 auto;']) !!}
					<p style="font-size:11px;">Home</p>
				</div>
				<div onclick="location.href='{{ URL::route('frontend.product.index') }}';" class="col-xs-{{(Auth::user())?"3":"4"}} text-center" style="border-right:1px solid #ddd; height:75px; padding-top: 8px; padding-bottom: 8px;">
					{!! HTML::image('Balin/web/image/product.png', 'image' ,['style' => 'padding-top:6px; padding-bottom:6px; height:37px; width:25px; margin: 0 auto;']) !!}
					<p style="font-size:11px;">Produk</p>
				</div>
				@if (Auth::user())
				<div onclick="location.href='{{ URL::route('frontend.user.index') }}';" class="col-xs-3 text-center" style="border-right:1px solid #ddd; height:75px; padding-top: 8px; padding-bottom: 8px;">
					{!! HTML::image('Balin/web/image/profile.png', 'image' ,['style' => 'padding-top:6px; padding-bottom:6px; height:37px; width:25px; margin: 0 auto;']) !!}
					<p style="font-size:11px;">Profile</p>
				</div>
				@endif
				@if (Auth::user())
				<div onclick="location.href='{{ URL::route('frontend.dologout') }}';" class="col-xs-3 text-center" style="height:75px; padding-top: 8px; padding-bottom: 8px;">
					{!! HTML::image('Balin/web/image/sign-out.png', 'image' ,['style' => 'padding-top:6px; padding-bottom:6px; height:37px; width:25px; margin: 0 auto;']) !!}
				@else
				<div onclick="location.href='{{ URL::route('frontend.join.index') }}';" class="col-xs-4 text-center" style="height:75px; padding-top: 8px; padding-bottom: 8px;">
					{!! HTML::image('Balin/web/image/sign-in.png', 'image' ,['style' => 'padding-top:6px; padding-bottom:6px; height:37px; width:25px; margin: 0 auto;']) !!}
				@endif
					<p style="font-size:11px;">{{(Auth::user())?"Log Out":"Sign In"}}</p>
				</div>		
			</div>
		</div>

	</div>

	<div class="container"></div>
	<!-- <div id="footer"></div> -->
	@include('widgets.footer')

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

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-71083357-1', 'auto');
		ga('send', 'pageview');

	</script>
</body>

</html>
@stop
