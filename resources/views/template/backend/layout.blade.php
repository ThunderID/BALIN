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
   {!! HTML::style('Balin/admin/css/bootstrap.min.css') !!}
   {!! HTML::style('Balin/admin/css/sb-admin.css') !!}
   {!! HTML::style('Balin/admin/css/metisMenu.css') !!}
   {!! HTML::style('Balin/admin/plugin/fontawesome/css/font-awesome.min.css') !!}
</head>

<body>
    <div id="wrapper">

        @include('widgets.backend.nav')

        <div id="page-wrapper">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    {!! HTML::script('/Balin/admin/js/jquery.js') !!}
    {!! HTML::script('/Balin/admin/js/bootstrap.min.js') !!}
    {!! HTML::script('/Balin/admin/js/metisMenu.min.js') !!}
    <!-- jQuery -->
    <script type="text/javascript">
        $(function () {
           $('#side-menu').metisMenu();
         });
    </script>
</body>

</html>
@stop