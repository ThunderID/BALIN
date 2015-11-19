<nav class="navbar navbar-inverse navbar-fixed-top m-b-none" role="navigation">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">

					<button type="button" class="navbar-toggle collapsed link-grey hover-white" aria-expanded="false" data-toggle="collapse" aria-controls="#bs-example-navbar-collapse-1" data-target="#bs-example-navbar-collapse-1" style="color:#fff; border-radius:0; border: none">
						<i class="fa fa-bars fa-lg"></i>
						{{-- <span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> --}}
					</button>
					<a href="{{ route('frontend.cart.index') }}" class="hidden-sm hidden-md hidden-lg ico-cart link-grey hover-white" style="color: #fff;
					    position: absolute;
					    right: 80px;
					    top: 16px;
					    text-decoration:none;">
						<i class="fa fa-shopping-cart fa-lg"></i>
						<span class="m-l-xs">
							{{ count(Session::get('baskets')) }}
						</span>
					</a>
					<a class="navbar-brand" href="{{ URL::route('frontend.home.index') }}">
						{!! HTML::image('Balin/web/image/logo-transparent.png', null, ['class' => 'img-responsive m-t-xs']) !!}
					</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-hollow">
						<li @if($controller_name == 'home') class=active @endif>
							<a href="{{ URL::route('frontend.home.index') }}" data-scroll>Home</a>
						</li>
						<li @if($controller_name == 'product') class=active @endif >
							<a href="{{ URL::route('frontend.product.index') }}">Produk</a>
						</li>
						{{-- <li @if($controller_name == 'whyjoin') class=active @endif>
							<a href="{{ URL::route('frontend.whyjoin.index') }}" data-scroll>Why Join</a>
						</li> --}}
						@if (!Auth::user())
							<li @if($controller_name == 'join') class=active @endif >
								<a href="{{ URL::route('frontend.join.index') }}" data-scroll>Sign In</a>
							</li>
						@endif
						<li @if($controller_name == 'aboutus') class=active @endif>
							<a href="{{ URL::route('frontend.aboutus.index') }}" data-scroll>About Us</a>
						</li>
						<!-- <li>
							<a href="{{ URL::route('frontend.home.index') }}#contact-us" data-scroll>Contact Us</a>
						</li> -->
						@if (Auth::user())
							<li class="@if($controller_name == 'profile') active @endif dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle">Akun Saya</a>
								@include('widgets.frontend.top_menu.user_dropdown')
							</li> 
						@endif
						<li class="@if($controller_name == 'cart') active @endif dropdown dropdown-cart">
							<a href="javascript:void(0);" class="dropdown-toggle ico-cart">
								<i class="fa fa-shopping-cart fa-lg"></i>
								<span class="m-l-xs">
									{{ count(Session::get('baskets')) }}
								</span>
							</a>
							@include('widgets.frontend.top_menu.cart_dropdown')
						</li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
		</div>
	</div>
</nav>