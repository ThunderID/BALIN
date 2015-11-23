@extends('template.layout')

@section('content_layout')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>CMS - BALIN.ID</title>

	<!-- Custom CSS -->
	{!! HTML::style('Balin/admin/css/bootstrap.min.css') !!}
	{!! HTML::style('Balin/admin/css/font-awesome.min.css') !!}
	{!! HTML::style('Balin/admin/css/style.css') !!}
   <link rel="shortcut icon" href="{{ url('Balin/web/image/favicon.ico') }} "/>

</head>

<body>
	<div class="middle-box text-center loginscreen animated fadeInDown">
		<div>
			<div>
				{!! HTML::image('Balin/admin/image/logo.png') !!}
			</div>
			<h4>A D M I N I S T R A T O R</h4>
			<br><br>
			{{-- <p>Login in. To see page admin.</p> --}}
			@yield('content')
		</div>
	</div>
	<!-- /#wrapper -->
	<!-- jQuery -->
	{!! HTML::script('/Balin/admin/js/jquery.js') !!}
	{!! HTML::script('/Balin/admin/js/bootstrap.min.js') !!}
</body>

</html>
@stop