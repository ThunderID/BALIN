<footer class="container-fluid footer">
	<div class="row">
		<div class="col-md-12">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-6">
						{!! HTML::image('Balin/web/image/logo.png','', ['class' => 'img-responsive']) !!}
						<ul class="list-inline menu-footer">
							<li><a href="{{ URL::route('frontend.aboutus.index') }}" class="footer-link">&copy; 2015 Balin.</a></li>
							<li><a href="{{ URL::route('frontend.contactus.index') }}">Contact US</a></li>
						</ul>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-6 text-right">
						<a href="{{ $storeinfo['facebook_url'] }}" class="btn-hollow hollow-social hollow-white btn-hollow-xs"><i class="fa fa-facebook fa-2x"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>