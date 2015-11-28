<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width"/>
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
						<a href="{{ URL::route('frontend.aboutus.index') }}" style="color:white;text-align:center;text-decoration:none">ABOUT US</a> <span style="color:white">|</span> <a href="{{ URL::route('frontend.contactus.index') }}" style="color:white;text-align:center;text-decoration:none">CONTACT US</a>
						<p class="footer-title-logo m-t-sm m-b-none"><a href="{{ URL::route('frontend.home.index') }}"  style="color:white;text-align:center;text-decoration:none">Copyright &copy; 2015 Balin.id</a></p>
						<p class="footer-title-logo m-b-none"><a href="{{ URL::route('frontend.home.index') }}"  style="color:white;text-align:center;text-decoration:none">Website by Thunder Labs Indonesia</a></p>
					</td>		
					<td class="row" style="width:25%;" valign="middle">
							<a href="{{ $data['balin']['instagram_url'] }}" target="blank" class="btn-hollow hollow-social hollow-white social-mobile" style="color:white;">{!! HTML::image('http://www.soteeoh.com/images/inst.png','', ['class' => 'img-responsive', 'style' => 'text-align:center;max-width:25px;']) !!}</a>&nbsp;&nbsp;
							<a href="{{ $data['balin']['twitter_url'] }}" target="blank" class="btn-hollow hollow-social hollow-white social-mobile" style="color:white;">{!! HTML::image('http://peavey.com/includes/images/Twitter_logo_white_tiny.png','', ['class' => 'img-responsive', 'style' => 'text-align:center;max-width:25px;']) !!}</a>&nbsp;&nbsp;
							<a href="{{ $data['balin']['facebook_url'] }}" target="blank" class="btn-hollow hollow-social hollow-white social-mobile" style="color:white;">{!! HTML::image('http://static1.squarespace.com/static/54e509a7e4b029114fa305cc/t/54f4c9dbe4b02c0acdf35a13/1425328607960/thefathership-fb-logo.png','', ['class' => 'img-responsive', 'style' => 'text-align:center;max-width:25px;']) !!}</a>&nbsp;&nbsp;
						</div>
					</td>		
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</div>
	</body>
</html>
