<footer class="container-fluid footer">
	<div class="row">
		<div class="col-md-12">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<ul class="list-inline menu-footer">
							<li><a href="{{ URL::route('frontend.aboutus.index') }}">About US</a></li>
							<li><a href="{{ URL::route('frontend.home.index') }}#contact-us">Contact US</a></li>
						</ul>
					</div>
					<div class="col-md-4 text-right">
						<a href="{{ $storeinfo['facebook_url'] }}" class="btn-hollow hollow-social hollow-white btn-hollow-xs"><i class="fa fa-facebook"></i></a>
						<a href="{{ $storeinfo['twitter_url'] }}" class="btn-hollow hollow-social hollow-white btn-hollow-xs"><i class="fa fa-twitter"></i></a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
							<p class="">&copy; 2015 Balin.</p>
					</div>
				</div>			
			</div>
		</div>
	</div>
</footer>