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
   {!! HTML::style('Balin/admin/css/select2.css') !!}

</head>

<body>
    <div id="wrapper">

        @include('widgets.backend.pageelements.nav')

        <div id="page-wrapper">
            <div class="container-fluid">
                @include('widgets.backend.pageelements.pagetitle')
                @include('widgets.backend.pageelements.breadcrumb')
                @include('widgets.backend.pageelements.alertBox')
                @yield('content')
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    {!! HTML::script('/Balin/admin/js/jquery.js') !!}
    {!! HTML::script('/Balin/admin/js/bootstrap.min.js') !!}
    {!! HTML::script('/Balin/admin/js/metisMenu.min.js') !!}
    {!! HTML::script('/Balin/admin/js/select2.min.js') !!}
    {!! HTML::script('/Balin/admin/js/inputmask.js') !!}
    {!! HTML::script('/Balin/admin/js/dynamicForm.js') !!}
    
    <!-- jQuery -->
    <script type="text/javascript">
        $(function () {
           $('#side-menu').metisMenu();
        });

        $(document).ready(function(){
            $(".IDRCurrencyL").inputmask({ rightAlign: false, alias: "numeric", prefix: 'Rp ', radixPoint: '', placeholder: "", autoGroup: !0, digitsOptional: !1, groupSeparator: '.', groupSize: 3, repeat: 15 });              
            $(".IDRCurrencyR").inputmask({ rightAlign: true, alias: "numeric", prefix: 'Rp ', radixPoint: '', placeholder: "", autoGroup: !0, digitsOptional: !1, groupSeparator: '.', groupSize: 3, repeat: 15 });              
        });

        @yield('script')
        @yield('scriptDelete')
    </script>
</body>

</html>
@stop