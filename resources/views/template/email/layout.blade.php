<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width"/>
		{!! HTML::style('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700') !!}
		<style type="text/css">
			body {
				font-family: 'Roboto', sans-serif;
				font-size: 14px;
			}
			.title-circle {
				width: 55px;
			}
			.title-circle:after {
				content: "";
				display: block;
				width: 100%;
				height: 0;
				padding-bottom: 100%;
				background: #999;
				border-radius: 50%;
			}
			.title-circle div {
				font-weight: 100;
				font-size: 13px;
				float: left;
				width: 100%;
				padding-top: 50%;
				line-height: 1em;
				margin-top: -0.4em;
				text-align: center;
				color: white;
			}
			.title-circle.active:after {
				background: #000;
			}
		</style>
	</head>
	<body>
		<div class="row" style="margin:50px;">
			@yield('content')
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
		</div>
	</body>
</html>
