<footer class="container-fluid footer" style="padding-bottom:20px;">
	<div class="row">
		<div class="col-md-12">
			<div class="container">
				<div class="row p-t-xs p-b-md">
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<a href="{{ URL::route('frontend.home.index') }}">{!! HTML::image('Balin/web/image/logo.png','', ['class' => 'img-responsive']) !!}</a>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center m-t-sm">
						<ul class="list-inline menu-footer">
							<li><a href="{{ URL::route('frontend.aboutus.index') }}">ABOUT US</a></li>
							<li>|</li>
							<li><a href="{{ URL::route('frontend.contactus.index') }}">CONTACT US</a></li>
						</ul>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
						<a href="{{ $storeinfo['facebook_url'] }}" class="btn-hollow hollow-social hollow-white btn-hollow-xs"><i class="fa fa-facebook fa-2x"></i></a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<p class="footer-title-logo m-t-sm m-b-none"><a href="{{ URL::route('frontend.home.index') }}">Copyright &copy;, 2015 Balin.id</a></p>
						<p class="footer-title-logo m-b-none"><a href="{{ URL::route('frontend.home.index') }}">Website by Thunder Lab Indonesia</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>