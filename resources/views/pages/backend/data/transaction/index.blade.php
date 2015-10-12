@extends('template.backend.layout')

@section('content')
<div class="container-fluid">
	@include('widgets.backend.pageElements.pageTitle')
    @include('widgets.backend.pageElements.breadcrumb')
    @include('widgets.backend.pageElements.alertBox')
	<div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-8 col-sm-4 hidden-xs">
                    <a data-backdrop="static" data-keyboard="false" class="btn btn-default" href="#" data-toggle="modal" data-target="#trans" data-button="Tambah Data" data-title="Tambah Data Pengiriman Barang"> Tambah Data </a>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                </div>
                <div class="col-md-4 col-sm-8 col-xs-12">
                    {!! Form::open(array('route' => 'backend.transaction.index', 'method' => 'get' )) !!}
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
            @include('widgets.backend.pageElements.headerSearchResult', ['closeSearchLink' => route('backend.transaction.index') ])
            </br> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="col-md-2">Nota Transaksi</th>
                                    <th class="col-md-4">Nama</th>
                                    <th class="col-md-2">Tanggal Transaksi</th>
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
                                        <td colspan="6" class="text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @else                                                                 
                                    @foreach($datas as $data)
                                    <tr>
                                        <td>{{$ctr}}</td>
                                        <td>{{$data['invoice_no']}}</td>
                                        <td>{{$data['customer']['name']}}</td>
                                        <td>{{$data['date']}}</td>
                                        <td>
                                        	@if($data['status'] == 0)
                                        		Cancel
                                        	@elseif($data['status'] == 1)
                                        		Pending
                                        	@elseif($data['status'] == 2)
                                        		Waiting for Payment
                                        	@elseif($data['status'] == 3)
	                                        	Processing
                                        	@elseif($data['status'] == 4)
	                                        	Shipping
                                        	@elseif($data['status'] == 5)
                                        		Delivered
                                        	@else
                                        		N.a
                                        	@endif
                                        </td>
                                        <td>
                                            <a href="{{ route('backend.courier.detail', ['courier_id' => $data['id']]) }}">Detail</a>,
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#trans" 
                                                data-id="{{ $data['id'] }}" 
                                                data-nota-transaksi="{{ $data['invoice_no'] }}" 
                                                data-name="{{ $data['customer']['name'] }}" 
                                                data-date="{{ $data['date'] }}" 
                                                data-status="{{ $data['status'] }}"  
                                                data-title="Edit Data {{ $data['transaction']['invoice_no'] }}" 
                                                data-button="Simpan Data"
                                                href="#">
                                                Edit
                                            </a>,  
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#trans_del"
                                                data-id="{{$data['id']}}"
                                                data-title="Hapus Data Transaksi {{$data['invoice_no']}}" 
                                                data-button="Hapus Data"
                                                data-id="{{$data['id']}}"
                                                href="#">
                                                Hapus
                                            </a>                                            
                                        </td>    
                                    </tr>       
                                    <?php $ctr += 1; ?>                     
                                    @endforeach 
                                    @include('widgets.pageElements.formModal1', array('modal_id'=>'trans_del', 'modal_content' => 'pages.backend.transaction.delete'))
                                @endif
                            </tbody>
                        </table> 
                    </div>                 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align:right;">
                    {!! $datas->appends(Input::all())->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@include('widgets.pageElements.formModal2', array('modal_id'=>'trans', 'modal_content' => 'pages.backend.transaction.create'))                                    
@stop

@section('script')
    $('#trans_del').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).attr('data-id');
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');

        $('.mod_pwd').val('');
        $('.mod_id').val(id);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    }) 

    $('#trans').on('show.bs.modal', function (e) {
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');
        var id = $(e.relatedTarget).attr('data-id');
        var nota_transaksi = $(e.relatedTarget).attr('data-nota-transaksi');
        var name = $(e.relatedTarget).attr('data-name');
        var phone = $(e.relatedTarget).attr('data-phone');
        var address = $(e.relatedTarget).attr('data-address');
        var zip = $(e.relatedTarget).attr('data-zip');
        var courier = $(e.relatedTarget).attr('data-courier');
        var code = $(e.relatedTarget).attr('data-code');
        var cost = $(e.relatedTarget).attr('data-cost');
        var date = $(e.relatedTarget).attr('data-date');

        $('.mod_id').val(id);
        $('.mod_nota_transaksi').val(nota_transaksi);
        $('.mod_date').val(date);
        $('.mod_name').val(name);
        $('.mod_phone').val(phone);
        $('.mod_address').val(address);
        $('.mod_zip').val(zip);
        $('.mod_courier').val(courier);
        $('.mod_resi').val(code);
        $('.mod_cost').val(cost);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    })     
@stop