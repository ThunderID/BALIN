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
		a.link-gold{
			color:#C38322 !important;
		}
		a.link-gold:hover{
			color:#E18A07 !important;
		}
		a.link-black {
			color: #000 !important;
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
		a.hover-grey:hover{
		   color:#888 !important;
		}
		a.hover-white:hover {
			color: #fff !important;
		}
		a.hover-red:hover {
			color: #d91e18 !important;
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
			padding: 1px 6px !important;
			margin: 0px !important;
			line-height: 20px;
		}

		.ribbon{
			/*border-bottom: 1px solid #999;*/
			/*border-top: 1px solid #999;*/
			border: 2px solid #ddd;
		}

		.ribbon-menu li {
			padding:0px !important;
		} 

		.ribbon-menu li a {
			padding-top: 12px;
			padding-bottom: 10px;
			padding-right: 20px !important;
			padding-left: 20px !important;
			text-decoration: none;
			display: block; 
			width: 100%; 
			height: 100%;
		}

		.ribbon-menu li a:hover{
			color: #222;
		}		

		.ribbon-menu li i {
			padding-left: 10px;
			margin-top: 2px;
		}

		.ribbon-menu li:hover {
			/*background-color: #000;*/
			background-color: #ddd;
			color: white;
		} 	

		.ribbon-menu li a.active {
			background-color: #ddd;
			color: #222;
		} 	

		.ribbon-menu-mobile li a.active {
			background-color: #111 !important;
			color: white;
		} 	


		.ribbon-menu li a.active i{
			-ms-transform: rotate(180deg) scaleX(-1); /* IE 9 */
			-webkit-transform: rotate(180deg) scaleX(-1); /* Chrome, Safari, Opera */
			transform: rotate(180deg) scaleX(-1);
		}

		.ribbon-submenu li {
			padding:0px !important;
		} 

		.ribbon-submenu li a {
			padding-top: 12px;
			padding-bottom: 10px;
			padding-right: 20px !important;
			padding-left: 20px !important;
			text-decoration: none;
			display: block; 
			width: 100%; 
			height: 100%;
			background-color: #111;
			color: white;
		}
		.ribbon-submenu li a.active {
			border: 1px solid #ddd;
		    color: #ddd;
		    font-weight: 600;
		}

		.ribbon-submenu {
			background-color: #111;
		}

		.ribbon-submenu .head-ribbon {
			padding-left: 20px;
			color: #999;
			border-bottom: 1px solid #999;
		}

		.ribbon-submenu li i {
			padding-left: 10px;
			margin-top: 2px;
		}

		.ribbon-submenu li:hover {
			background-color: #000;
			color: white;
		} 		

		.ribbon-submenu li:hover a {
			color: #fff;
			background-color: #000;
			text-decoration: underline;
		}

		.ribbon-mobile {
			padding: 0px !important; 
		}	

		.ribbon-mobile-submenu {
			padding: 0px !important; 
		}		

		.ribbon-mobile-title {
			padding-top: 5px;
			width: 100%; 
			text-align: center; 
			border-bottom: 1px solid #444; 
			line-height: 0.1em;
			margin: 10px 0 20px; 
		} 

		.ribbon-mobile-title span { 
			background:#fff; 
			padding:0 10px; 
		}

		.ribbon-title  {
			padding : 5px;
		} 


		@media(max-width: 767px) {
			.dropdown-cart {
				display: none !important;
			}
			.user-dropdown {
				display: none !important;
			}
		}

		.dialog-mobile{
			width:90% !important;
			border-radius: none !important;
		}

		.modal-filter-title{
			background-color: black;
			color:white;
		}

		.modal-filter-title button{
			color:#ddd !important;
			opacity: 1 !important;
		}	

		.modal-filter-title button:hover{
			color:white !important;
			opacity: 1 !important;
		}				

		.modal-center.modal {
		  text-align: center !important;
		  padding: 0!important;
		}

		.modal-center.modal:before {
		  content: '' !important;
		  display: inline-block !important;
		  height: 100% !important;
		  vertical-align: middle !important;
		  margin-right: -4px !important;
		}

		.modal-center .modal-dialog {
			display: inline-block !important;
			vertical-align: middle !important;
		}

		.modal-center .modal-content {
			border-radius: 0px !important;
		}

		.modal-notif .modal-dialog{
			background-color: white;
		}

		.modal-notif .modal-header{
			background-color: black;
			color:white;
			border-bottom: none;
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

/* .modal-fullscreen */

.modal-fullscreen {
	background-color: rgba(255, 255, 255, 0.95);
	z-index: 99999;
}
.modal-fullscreen .modal-content {
	background: transparent;
	border: 0;
	-webkit-box-shadow: none;
	box-shadow: none;
}
.modal-backdrop.modal-backdrop-fullscreen {
	background: #ffffff;
}
.modal-backdrop.modal-backdrop-fullscreen.in {
	opacity: .97;
	filter: alpha(opacity=97);
}

/* .modal-fullscreen size: we use Bootstrap media query breakpoints */

.modal-fullscreen .modal-dialog {
	margin: 0;
	margin-right: auto;
	margin-left: auto;
	width: 100%;
}
.modal-fullscreen .modal-header {
	margin-left: -100px;
	margin-right: -100px;
	padding-left: 115px;
	padding-right: 115px;
	background-color: #000;
	color: #fff;
}
.modal-fullscreen .modal-header button.close {
	background: none;
	opacity: 1;
	font-size: 16px;
	color: #fff;
	line-height: 25px;
	outline: none;
}

@media (min-width: 768px) {
	.modal-fullscreen .modal-dialog {
		width: 750px;
	}
}
@media (min-width: 992px) {
	.modal-fullscreen .modal-dialog {
		width: 970px;
	}
}
@media (min-width: 1200px) {
	.modal-fullscreen .modal-dialog {
		width: 1170px;
	}
}

@media (max-width: 768px) {
	.mobile-m-t-0 {
		margin-top: 0px !important;
	}

	.mobile-m-t-25 {
		margin-top: 25px !important;
	}	

	.mobile-m-t-10 {
		margin-top: 10px !important;
	}	
}

.footer-title-logo {
	letter-spacing: 0.25em !important;
	font-size: 12px;
}

.footer-title-logo a{
	color:white !important;
}

.footer-title-logo a:hover{
	text-decoration: none !important;
}

@media (max-width: 352px) {
	.footer-title-logo {
		letter-spacing: 0.09em !important;
	}	
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

.social-mobile{
	width: 30px;
	height: 30px;
	padding: 4px 5px !important;
}

.social-mobile i{
    font-size: 1.5em;
}


@media (max-width: 400px) {
	.error-responsive {
		padding-top: 32% !important;
	}

	.error-responsive h1 {
		font-size: 150px;
	}	
}


@media (min-width: 401px) and (max-width: 500px) {
	.error-responsive {
		padding-top: 23% !important;
	}

	.error-responsive h1 {
		font-size: 160px;
	}	
}

@media (min-width: 501px) and (max-width: 600px) {
	.error-responsive {
		padding-top: 18% !important;
		padding-left: 4%;
		padding-right: 4%;		
	}

	.error-responsive h1 {
		font-size: 175px;
	}	
}

@media (min-width: 601px) and (max-width: 700px) {
	.error-responsive {
		padding-top: 13% !important;
		padding-left: 10%;
		padding-right: 10%;
	}

	.error-responsive h1 {
		font-size: 200px;
	}	
}

@media (min-width: 701px) and (max-width: 767px) {
	.error-responsive {
		padding-top: 10% !important;
		padding-left: 13%;
		padding-right: 13%;
	}

	.error-responsive h1 {
		font-size: 240px;
	}	
}

@media (min-width: 768px) and (max-width: 991px) {
	.error-responsive {
		padding-top: 6% !important;
		padding-left: 10%;
		padding-right: 10%;
	}

	.error-responsive h1 {
		font-size: 240px;
	}	
}

@media (min-width: 992px) and (max-width: 1199px) {
	.error-responsive {
		padding-top: 5% !important;
	}

	.error-responsive h1 {
		font-size: 240px;
	}	
}

@media (min-width: 1200px) {
	.error-responsive {
		padding-top: 6% !important;
	}

	.error-responsive h1 {
		font-size: 240px;
	}	
}

@media (max-width: 359px) {
	.info-product h4 {
	    white-space: nowrap;
	    overflow: hidden;
	    text-overflow: ellipsis;  
	    max-height: 58px;  
	    font-size: 15px;
	}	

	.info-price {
		margin-top: -30px;
	}
}


@media (min-width: 360px) and (max-width: 369px){
	.info-product h4 {
	    font-size: 13px !important;  
	}	
}

@media (min-width: 370px) and (max-width: 429px) {
	.info-product h4 {
	    font-size: 14px;  
	}	
}

@media (min-width: 430px) and (max-width: 489px) {
	.info-product h4 {
	    font-size: 15px;  
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
	@if($controller_name == 'home') <?php $pb = 0; ?>@endif
	
	<div id="container">

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
	{!! HTML::script('Balin/web/js/jquery.js') !!}
	{!! HTML::script('Balin/web/js/bootstrap.min.js') !!}

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
