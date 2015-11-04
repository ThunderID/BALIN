@extends('template.layout')

@section('content_layout')
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Balin</title>
		<!-- Custom CSS -->
		{!! HTML::style('Balin/web/css/bootstrap.min.css') !!}
		<link rel="stylesheet" href="{{ elixir('Balin/web/css/style-web.css') }}">
		{!! HTML::style('Balin/web/plugin/fontawesome/css/font-awesome.min.css') !!}
		{!! HTML::style('http://fonts.googleapis.com/css?family=Lato:200,400,300,700') !!}
	</head>

	<body>
		<!-- Header -->
		<header class="page-header">
			@include('widgets.top_menu')
		</header>

		@yield('content')

		{{-- @if ($controller_name != 'home') --}}
			@include('widgets.footer')
		{{-- @endif --}}

		<!-- jQuery -->
		{!! HTML::script('Balin/web/js/jquery.js') !!}
		{!! HTML::script('Balin/web/js/bootstrap.min.js') !!}
		{!! HTML::script('Balin/web/plugin/smooth-scroll/smooth-scroll.min.js') !!}

		<!-- Script to Activate the Carousel -->
		<script>
			$('.carousel').carousel({
				interval: false //changes the speed
			});
		
			@yield('script')
			@include('widgets.scripts.inputNumberValidator')

			$('ul.nav li.dropdown').hover(function() {        
				$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(300);
			}, function() {
				$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
			});

		    smoothScroll.init({
		        selector: '[data-scroll]', // Selector for links (must be a valid CSS selector)
		        selectorHeader: '[data-scroll-header]', // Selector for fixed headers (must be a valid CSS selector)
		        speed: 900, // Integer. How fast to complete the scroll in milliseconds
		        easing: 'easeInOutCubic', // Easing pattern to use
		        updateURL: true, // Boolean. Whether or not to update the URL with the anchor hash on scroll
		        offset: 50, // Integer. How far to offset the scrolling anchor location in pixels
		        callback: function ( toggle, anchor ) {} // Function to run after scrolling
		    });
		</script>
		@yield('script_plugin')
	</body>

	</html>
@stop