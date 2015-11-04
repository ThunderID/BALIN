@extends('template.layout')

@section('content_layout')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Balin</title>

	<!-- Custom CSS -->
   {!! HTML::style('Balin/admin/css/bootstrap.min.css') !!}
   {!! HTML::style('Balin/admin/css/font-awesome.min.css') !!}
   {!! HTML::style('Balin/admin/css/style.css') !!}

</head>

<body>
	<div id="wrapper">
		@include('widgets.backend.pageelements.nav')
		
		<div id="page-wrapper" class="white-bg dashbard-1">
			<div class="row border-bottom">
				@include('widgets.backend.pageelements.topbar')
			</div>
			<div class="row  border-bottom white-bg dashboard-header">
				<div class="col-lg-10">
					@include('widgets.backend.pageelements.pagetitle')
	            @include('widgets.backend.pageelements.breadcrumb')
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="wrapper wrapper-content">
						@include('widgets.backend.pageelements.alertbox')
						@yield('content')
					</div>
				</div>
			</div>
		</div>
		<!-- /#page-wrapper -->
	</div>
	<!-- /#wrapper -->
	<!-- jQuery -->
	{!! HTML::script('/Balin/admin/js/jquery.js') !!}
	{!! HTML::script('/Balin/admin/js/bootstrap.min.js') !!}
	{!! HTML::script('/Balin/admin/js/metisMenu.min.js') !!}
	{!! HTML::script('/Balin/admin/js/select2.min.js') !!}
	{!! HTML::script('/Balin/admin/js/inputmask.js') !!}
	{!! HTML::script('/Balin/admin/js/dynamicForm.js') !!}
	
	<!-- jQuery -->
	<script type="text/javascript">
		$(function () {
		   $('#side-menu').metisMenu();
		});

		$(document).ready(function(){
			$(".IDRCurrencyL").inputmask({ rightAlign: false, alias: "numeric", prefix: 'Rp ', radixPoint: '', placeholder: "", autoGroup: !0, digitsOptional: !1, groupSeparator: '.', groupSize: 3, repeat: 15 });              
			$(".IDRCurrencyR").inputmask({ rightAlign: true, alias: "numeric", prefix: 'Rp ', radixPoint: '', placeholder: "", autoGroup: !0, digitsOptional: !1, groupSeparator: '.', groupSize: 3, repeat: 15 });              
			$(".date-time-format").inputmask({
		        mask: "d-m-y h:s",
		        placeholder: "dd-mm-yyyy hh:mm",
		        alias: "datetime",
		    });              
		});

		@yield('script')
		@yield('scriptDelete')
	</script>
	@yield('script_plugin')
</body>

</html>
@stop