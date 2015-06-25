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
    @include('widgets.topMenu')

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
