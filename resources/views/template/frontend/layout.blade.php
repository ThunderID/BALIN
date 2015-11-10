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
   {!! HTML::style('https://fonts.googleapis.com/css?family=Roboto:400,300,100,700') !!}

</head>

<body>
    <header class="page-header">
        @include('widgets.top_menu')
    </header>

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
    // $('.carousel').carousel({
    //     interval: 5000 //changes the speed
    // })
    
    @yield('script')

    @include('widgets.scripts.inputNumberValidator')

    $('ul.nav li.dropdown').hover(function() {        
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(300);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
    });

    function number_format(number, decimals, dec_point, thousands_sep) {
      number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

      var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k).toFixed(prec);
            };

      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }

        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
    </script>
    @yield('script_plugin')
</body>

</html>
@stop
