<footer class="container-fluid footer" style="padding-bottom:20px;">
	<div class="row">
		<div class="col-md-12">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-6">
						<a href="{{ URL::route('frontend.home.index') }}">{!! HTML::image('Balin/web/image/logo.png','', ['class' => 'img-responsive']) !!}</a>
						<p class="footer-title-logo"><a href="{{ URL::route('frontend.home.index') }}">&copy; 2015 Balin</a></p>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-6 text-right">
						<a href="{{ $storeinfo['facebook_url'] }}" class="btn-hollow hollow-social hollow-white btn-hollow-xs"><i class="fa fa-facebook fa-2x"></i></a>
					</div>
				</div>
				<div class="row p-t-xs">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<ul class="list-inline menu-footer">
							<li><a href="{{ URL::route('frontend.aboutus.index') }}">About Us</a></li>
							<li>|</li>
							<li><a href="{{ URL::route('frontend.contactus.index') }}">Contact Us</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>