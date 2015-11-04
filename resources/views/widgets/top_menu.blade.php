<nav class="navbar navbar-inverse navbar-fixed-top m-b-none" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" aria-expanded="false" data-toggle="collapse" aria-controls="#bs-example-navbar-collapse-1" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
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
                    <a href="{{ URL::route('frontend.product.index') }}">Products</a>
                </li>
                <li @if($controller_name == 'whyjoin') class=active @endif>
                    <a href="{{ URL::route('frontend.home.index') }}#why-join" data-scroll>Why Join</a>
                <li @if($controller_name == 'join') class=active @endif >
                    <a href="{{ URL::route('frontend.home.index') }}#sign-in" data-scroll>Sign In</a>
                </li>
                <li>
                    <a href="{{ URL::route('frontend.home.index') }}#about-us" data-scroll>About Us</a>
                </li>
                <li>
                    <a href="{{ URL::route('frontend.home.index') }}#contact-us" data-scroll>Contact Us</a>
                </li>
                @if (Auth::user())
                    <li @if($controller_name == 'profile') class=active @endif>
                        <a href="{{ URL::route('frontend.profile.index') }}">My Account</a>
                    </li> 
                @endif
                <li @if($controller_name == 'cart') class=active @endif class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle">
                        <i class="fa fa-shopping-cart fa-lg"></i>
                        <span class="m-l-xs">
                            {{ count(Cookie::get('baskets')) }}
                        </span>
                    </a>
                    @include('widgets.frontend.top_menu.cart_dropdown')
                </li>                                                    
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>