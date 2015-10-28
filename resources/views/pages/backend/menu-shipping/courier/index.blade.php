@extends('template.backend.layout')

@section('content')
<div class="container-fluid">
	@include('widgets.backend.pageelements.pagetitle')
    @include('widgets.backend.pageelements.breadcrumb')
    @include('widgets.backend.pageelements.alertBox')
	<div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-8 col-sm-4 hidden-xs">
                    <a data-backdrop="static" data-keyboard="false" class="btn btn-default" href="#" data-toggle="modal" data-target="#cou" data-button="Tambah Data" data-title="Tambah Data Kurir"> Data Baru </a>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                    <a data-backdrop="static" data-keyboard="false" class="btn btn-default btn-block" href="#" data-toggle="modal" data-target="#cou" data-button="Tambah Data" data-title="Tambah Data Kurir"> Data Baru </a>
                </div>                
                <div class="col-md-4 col-sm-8 col-xs-12">
                    {!! Form::open(array('route' => 'backend.courier.index', 'method' => 'get' )) !!}
                    <div class="row">
                        <div class="col-md-2 col-sm-3 hidden-xs">
                        </div>
                        <div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
                            {!!Form::input('text', 'q', Null , ['class' => 'form-control', 'placeholder' => 'Cari sesuatu', 'required' => 'required', 'style'=>'text-align:right']) !!}                                          
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
                            <button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>            
            </div>
            @include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.courier.index' )])
            </br> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="col-md-8">Nama</th>
                                    <th class="col-md-2">Status</th>
                                    <th>Kontrol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $nop = ($datas->currentPage() - 1) * 15;
                                    $ctr = 1 + $nop;
                                ?>
                                @if(count($datas) == 0)
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @else                                                                
                                    @foreach($datas as $data)
                                    <tr>
                                        <td>{{$ctr}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
                                                    <div class="col-sm-2" style="text-align:center;">
                                                        <img class="imageCard-small" src="http://placehold.it/320x150" alt="">
                                                    </div>
                                                    <div class="col-sm-10">
                                                        {{$data['name']}}
                                                    </div>
                                                </div>
                                                <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                                                    <div class="col-xs-12" style="text-align:left;">
                                                        <img class="imageCard-small" src="http://placehold.it/320x150" alt="">
                                                    </div>
                                                    <div class="col-xs-12" style="text-align:left;">
                                                        {{$data['name']}}
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($data['status'] == 0)
                                                Tidak Aktif
                                            @elseif($data['status'] == 1)
                                                Aktif
                                            @else
                                                N.a
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('backend.courier.detail', ['courier_id' => $data['id']]) }}">Detail</a>,
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#cou" 
                                                data-id="{{ $data['id'] }}" 
                                                data-name="{{ $data['name'] }}" 
                                                data-status="{{ $data['status'] }}" 
                                                data-title="Edit Data {{$data['name']}}" 
                                                data-button="Simpan Data"
                                                href="#">
                                                Edit
                                            </a>,                                        
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#cou_del"
                                                data-id="{{$data['id']}}"
                                                data-title="Hapus Data Kurir {{$data['name']}}" 
                                                data-button="Hapus Data"
                                                data-id="{{$data['id']}}"
                                                href="#">
                                                Hapus
                                            </a>
                                        </td>    
                                    </tr>      
                                    <?php $ctr += 1; ?>                     
                                    @endforeach 
                                    @include('widgets.pageelements.formModal1', array('modal_id'=>'cou_del', 'modal_content' => 'pages.backend.menu-shipping.courier.delete'))
                                @endif
                            </tbody>
                        </table> 
                    </div>                 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align:right;">
                    {!! $datas->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@include('widgets.pageelements.formModal1', array('modal_id'=>'cou', 'modal_content' => 'pages.backend.menu-shipping.courier.create'))                                    
@stop

@section('script')
    $('#cou_del').on('show.bs.modal', function (e) {
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');

        $('.mod_pwd').val('');
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    })  

    $('#cou').on('show.bs.modal', function (e) {
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');
        var stat = $(e.relatedTarget).attr('data-status');
        var name = $(e.relatedTarget).attr('data-name');
        var id = $(e.relatedTarget).attr('data-id');

        $('.mod_id').val(id);
        $('.mod_status').val(stat);
        $('.mod_name').val(name);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    }) 
@stop