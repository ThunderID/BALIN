@extends('template.layout')

@section('content_layout')
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Balin</title>

    <!-- Custom CSS -->
   {!! HTML::style('Balin/web/css/bootstrap.min.css') !!}
   <link rel="stylesheet" href="{{ elixir('Balin/web/css/style-web.css') }}">
   {!! HTML::style('Balin/web/plugin/fontawesome/css/font-awesome.min.css') !!}
   {!! HTML::style('http://fonts.googleapis.com/css?family=Lato:400,300,700') !!}

</head>

<body>
    @include('widgets.topMenu')

    @yield('content')

    @if($controller_name != 'home')
        @include('widgets.footer')
    @endif


    <!-- /.container -->

    <!-- jQuery -->
    {!! HTML::script('Balin/web/js/jquery.js') !!}
    {!! HTML::script('Balin/web/js//bootstrap.min.js') !!}

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    
    @yield('script')

    @include('widgets.scripts.inputNumberValidator')

    $('ul.nav li.dropdown').hover(function() {        
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(300);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
    });

    </script>
    @yield('script_plugin')
</body>

</html>
@stop
