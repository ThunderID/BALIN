@inject('settings', 'App\Models\StoreSetting')
<?php
	$tmp = $settings->storeinfo(true)->get();
	foreach ($tmp as $key => $value) {
	   $storeinfo[$value->type]   = $value->value; 
	}
?>

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
		a.unstyle{
			 text-decoration: none;
		}
		a.link-grey{
			color:#999!important;
		}
		a.unstyle:hover{
			 text-decoration: none;
		}
		a.hover-black:hover{
		   color:#000 !important;
		}
		a.hover-gray:hover{
		   color:#888 !important;
		}
		a.hover-white:hover {
			color: #fff !important;
		}

		a.footer-link{
			color:#bbb !important;
		}

		a.footer-link:hover{
			color:#fff !important;
		}


		   
		.text-product.small-price {
			font-size: 10pt !important;
		}  

		.m-t-0{
			margin-top: 0px !important;
		}  


		.m-b-0{
			margin-bottom: 0px;
		}         


		.mb-100{
			margin-bottom: 100px;
		}
		
		.btn-share{
			font-size: 12px !important; 
			height: 20px;
			padding: 1px 7px !important;
			margin: 0px !important;
		}
		@media(max-width: 767px) {
			.dropdown-cart {
				display: none !important;
			}
		}
	</style>

	<!-- Custom CSS -->
   {!! HTML::style('Balin/web/css/bootstrap.min.css') !!}
   {!! HTML::style('Balin/web/css/layout.css') !!}
   <link rel="stylesheet" href="{{ elixir('Balin/web/css/style-web.css') }}">
   {!! HTML::style('Balin/web/plugin/fontawesome/css/font-awesome.min.css') !!}
   {!! HTML::style('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700') !!}

   <link rel="shortcut icon" href="{{ url('Balin/web/image/favicon.ico') }} "/>

</head>

<body>
	<?php $pb = 90; ?>
	@if($controller_name == 'home') <?php $pb = 0; ?>@endif
	
	<div id="container" style="padding-bottom: {{$pb}} px;">

		<header class="page-header">
			@include('widgets.top_menu')
		</header>

		@yield('content')

	</div> 
	@if ($controller_name != 'home')

		<div class="container">&nbsp;</div>
		<div id="footer"></div>
		@include('widgets.footer')
	@endif

	<!-- /.container -->

	<!-- jQuery -->
	{!! HTML::script('Balin/web/js/jquery.js') !!}
	{!! HTML::script('Balin/web/js//bootstrap.min.js') !!}

	<!-- Script to Activate the Carousel -->
	<script>
	// $('.carousel').carousel({
	//     interval: 5000 //changes the speed
	// })
	
	@yield('script')

	@include('widgets.scripts.inputNumberValidator')

	$('ul.nav li.dropdown').hover(function() {        
		$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(300);
	}, function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
	});

	function number_format(number, decimals, dec_point, thousands_sep) {
	  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

	  var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + (Math.round(n * k) / k).toFixed(prec);
			};

	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}

		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}
	</script>
	@yield('script_plugin')
</body>

</html>
@stop
