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
			<table style="width:100%;background-color:black;">
				<tr><td>&nbsp;</td></tr>
				<tr class="col-xs-12" style="text-align:center">
					<td class="row" style="width:25%;" valign="middle" halign="middle" style = "text-align:center;">
						<a href="{{ URL::route('frontend.home.index') }}" style = "text-align:center;">{!! HTML::image('Balin/web/image/logo.png','', ['class' => 'img-responsive', 'style' => 'text-align:center;']) !!}</a>
					</td>
					<td class="row" style="width:50%;" valign="middle" style="text-align:center;">
						<a href="{{ URL::route('frontend.aboutus.index') }}" style="color:white;text-align:center;text-decoration:none">ABOUT US</a>&nbsp; <span style="color:white">|</span> &nbsp;<a href="{{ URL::route('frontend.contactus.index') }}" style="color:white;text-align:center;text-decoration:none">CONTACT US</a>
						<p class="footer-title-logo m-t-sm m-b-none"><a href="{{ URL::route('frontend.home.index') }}"  style="color:white;text-align:center;text-decoration:none">Copyright &copy; 2015 Balin.id</a></p>
						<p class="footer-title-logo m-b-none"><a href="{{ URL::route('frontend.home.index') }}"  style="color:white;text-align:center;text-decoration:none">Website by Thunder Labs Indonesia</a></p>
					</td>		
					<td class="row" style="width:25%;" valign="middle">
							@if(!is_null($data['balin']['instagram_url']) && !empty($data['balin']['instagram_url'] && $data['balin']['instagram_url'] != '' ))
							<a href="{{ $data['balin']['instagram_url'] }}" target="blank" class="btn-hollow hollow-social hollow-white social-mobile" style="color:white;">{!! HTML::image('Balin/web/image/logo-instagram.png','', ['class' => 'img-responsive', 'style' => 'text-align:center;max-width:30px;']) !!}</a>&nbsp;&nbsp;
							@endif
							@if(!is_null($data['balin']['twitter_url']) && !empty($data['balin']['twitter_url'] && $data['balin']['twitter_url'] != '' ))
								<a href="{{ $data['balin']['twitter_url'] }}" target="blank" class="btn-hollow hollow-social hollow-white social-mobile" style="color:white;">{!! HTML::image('Balin/web/image/logo-twitter.png','', ['class' => 'img-responsive', 'style' => 'text-align:center;max-width:30px;']) !!}</a>&nbsp;&nbsp;
							@endif
							@if(!is_null($data['balin']['facebook_url']) && !empty($data['balin']['facebook_url'] && $data['balin']['facebook_url'] != '' ))
							<a href="{{ $data['balin']['facebook_url'] }}" target="blank" class="btn-hollow hollow-social hollow-white social-mobile" style="color:white;">{!! HTML::image('Balin/web/image/logo-facebook.png','', ['class' => 'img-responsive', 'style' => 'text-align:center;max-width:30px;']) !!}</a>&nbsp;&nbsp;
							@endif
						</div>
					</td>		
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</div>
	</body>
</html>
