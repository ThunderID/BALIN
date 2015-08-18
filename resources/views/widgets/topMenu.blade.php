<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::route('frontend.home.index') }}">{!! HTML::image('Balin/image/logo.png') !!}</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li @if($controller_name == 'cart') class=active @endif>
                    <a href="{{ URL::route('frontend.cart.index') }}">Cart</a>
                </li>                                                    
                <li @if($controller_name == 'home') class=active @endif  }}>
                    <a href="{{ URL::route('frontend.home.index') }}">Home</a>
                </li>
                <li @if($controller_name == 'product') class=active @endif >
                    <a href="{{ URL::route('frontend.product.index') }}">Products</a>
                </li>
                <li @if($controller_name == 'join') class=active @endif >
                    <a href="{{ URL::route('frontend.join.index') }}">Join</a>
                </li>
                <li @if($controller_name == 'whyjoin') class=active @endif>
                    <a href="{{ URL::route('frontend.whyjoin.index') }}">Why Join</a>
                </li>    
                <li @if($controller_name == 'profile') class=active @endif>
                    <a href="{{ URL::route('frontend.profile.index') }}">Profile</a>
                </li> 
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>