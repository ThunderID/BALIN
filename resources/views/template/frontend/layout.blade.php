<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Full Slider - Start Bootstrap Template</title>

    <!-- Custom CSS -->
   {!! HTML::style('Balin/css/bootstrap.min.css') !!}
   {!! HTML::style('Balin/css/shop-homepage.css') !!}
   {!! HTML::style('Balin/plugin/fontawesome/css/font-awesome.min.css') !!}

</head>

<body>

    <!-- Navigation -->
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
                <a class="navbar-brand" href="{{ URL::route('home') }}">{!! HTML::image('Balin/image/logo.png') !!}</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li {{ Request::is('home') ? 'class=active' : '' }}>
                        <a href="{{ URL::route('home') }}">Home</a>
                    </li>
                    <li {{ Request::is('product') ? 'class=active' : '' }}>
                        <a href="{{ URL::route('product') }}">Products</a>
                    </li>
                    <li {{ Request::is('join') ? 'class=active' : '' }}>
                        <a href="{{ URL::route('join') }}">Join</a>
                    </li>
                    <li {{ Request::is('whyJoin') ? 'class=active' : '' }}>
                        <a href="{{ URL::route('whyJoin') }}">Why Join</a>
                    </li>                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    @yield('content')


    <!-- /.container -->

    <!-- jQuery -->
    {!! HTML::script('Balin/js/jquery.js') !!}
    {!! HTML::script('Balin/js//bootstrap.min.js') !!}

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
