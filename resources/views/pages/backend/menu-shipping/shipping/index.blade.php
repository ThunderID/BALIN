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
                    <a data-backdrop="static" data-keyboard="false" class="btn btn-default" href="#" data-toggle="modal" data-target="#shipp" data-button="Tambah Data" data-title="Tambah Data Pengiriman Barang"> Tambah Data </a>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                    <a data-backdrop="static" data-keyboard="false" class="btn btn-default btn-block" href="#" data-toggle="modal" data-target="#shipp" data-button="Tambah Data" data-title="Tambah Data Pengiriman Barang"> Kirim Barang </a>
                </div>
                <div class="col-md-4 col-sm-8 col-xs-12">
                    {!! Form::open(array('route' => 'backend.shipping.index', 'method' => 'get' )) !!}
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
            @include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.shipping.index') ])
            </br> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="col-md-2">Nota Transaksi</th>
                                    <th class="col-md-3">Kurir</th>
                                    <th class="col-md-">Resi Pengiriman</th>
                                    <th class="col-md-2">Tanggal Pengiriman</th>
                                    <th class="col-md-1">Status</th>
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
                                        <td>{{$data['transaction']['invoice_no']}}</td>
                                        <td>{{$data['courierBranch']['name']}}</td>
                                        <td>{{$data['code']}}</td>
                                        <td>{{$data['date']}}</td>
                                        <td>
                                        	@if(empty($data['code']))
                                        		Pending
                                        	@else
                                        		Shipped
                                        	@endif
                                        </td>
                                        <td>
                                            <a href="{{ route('backend.courier.detail', ['courier_id' => $data['id']]) }}">Detail</a>,
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#shipp" 
                                                data-id="{{ $data['id'] }}" 
                                                data-nota-transaksi="{{ $data['transaction']['invoice_no'] }}" 
                                                data-nota-transaksi-id="{{ $data['transaction']['invoice_no'] }}" 
                                                data-name="{{ $data['name'] }}" 
                                                data-phone="{{ $data['phone'] }}" 
                                                data-address="{{ $data['address'] }}" 
                                                data-zip="{{ $data['zip_code'] }}" 
                                                data-courier="{{ $data['courierBranch']['name'] }}" 
                                                data-courier-id="{{ $data['transaction_id'] }}" 
                                                data-code="{{ $data['code'] }}" 
                                                data-cost="{{ $data['transaction']['shipping_cost'] }}" 
                                                data-date="{{ $data['date'] }}" 
                                                data-title="Edit Data {{ $data['transaction']['invoice_no'] }}" 
                                                data-button="Simpan Data"
                                                href="#">
                                                Edit
                                            </a>,  
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#shipp_del"
                                                data-id="{{$data['id']}}"
                                                data-title="Hapus Data Pengirman Barang {{$data['transaction']['invoice_no']}}" 
                                                data-button="Hapus Data"
                                                data-id="{{$data['id']}}"
                                                href="#">
                                                Hapus
                                            </a>                                            
                                        </td>    
                                    </tr>       
                                    <?php $ctr += 1; ?>                     
                                    @endforeach 
                                    @include('widgets.pageelements.formModal1', array('modal_id'=>'shipp_del', 'modal_content' => 'pages.backend.menu-shipping.shipping.delete'))
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
@include('widgets.pageelements.formModal2', array('modal_id'=>'shipp', 'modal_content' => 'pages.backend.menu-shipping.shipping.create'))                                    
@stop

@section('script')
    $('#shipp_del').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).attr('data-id');
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');

        $('.mod_pwd').val('');
        $('.mod_id').val(id);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    }) 

    $('#shipp').on('show.bs.modal', function (e) {
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');
        var id = $(e.relatedTarget).attr('data-id');
        var nota_transaksi = $(e.relatedTarget).attr('data-nota-transaksi');
        var nota_transaksi_id = $(e.relatedTarget).attr('data-nota-transaksi-id');
        var name = $(e.relatedTarget).attr('data-name');
        var phone = $(e.relatedTarget).attr('data-phone');
        var address = $(e.relatedTarget).attr('data-address');
        var zip = $(e.relatedTarget).attr('data-zip');
        var courier = $(e.relatedTarget).attr('data-courier');
        var courier_id = $(e.relatedTarget).attr('data-courier-id');
        var code = $(e.relatedTarget).attr('data-code');
        var cost = $(e.relatedTarget).attr('data-cost');
        var date = $(e.relatedTarget).attr('data-date');

        $('.mod_id').val(id);
        $('.mod_date').val(date);
        $('.mod_name').val(name);
        $('.mod_phone').val(phone);
        $('.mod_address').val(address);
        $('.mod_zip').val(zip);
        
        if(id)
        {
            $('.mod_nota_transaksi').select2('data', {id: nota_transaksi_id, text: nota_transaksi});
            $('.mod_courier').select2('data', {id: courier_id, text: courier});
        }
        else
        {
            $('.mod_nota_transaksi').select2('data', '');
            $('.mod_courier').select2('data', '');
        } 

        $('.mod_resi').val(code);
        $('.mod_cost').val(cost);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    })

    $('#find_nota').select2({
        placeholder: '',
        minimumInputLength: 5,
        maximumSelectionSize : 1,
        tags: false,
        ajax: {
            url: '/cms/ajax/get-invoice',
            dataType: 'json',
            data: function (term, page) {
                return {
                    invoice_no: term
                };
            },
           results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.invoice_no +' ',
                            id: item.invoice_no +' '
                        }
                    })
                };
            },
            query: function (query){
                var data = {results: []};
                 
                $.each(preload_data, function(){
                    if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
                        data.results.push({id: this.id, text: this.text });
                    }
                });
 
                query.callback(data);
            }
        }
    });                


    $('#find_courier').select2({
        placeholder: '',
        minimumInputLength: 3,
        maximumSelectionSize : 1,
        tags: false,
        ajax: {
            url: '/cms/ajax/get-courierBranch',
            dataType: 'json',
            data: function (term, page) {
                return {
                    name: term
                };
            },
           results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name +' ',
                            id: item.name +' '
                        }
                    })
                };
            },
            query: function (query){
                var data = {results: []};
                 
                $.each(preload_data, function(){
                    if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
                        data.results.push({id: this.id, text: this.text });
                    }
                });
 
                query.callback(data);
            }
        }
    });
@stop         
