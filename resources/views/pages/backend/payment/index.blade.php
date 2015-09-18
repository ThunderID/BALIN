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
                    <a data-backdrop="static" data-keyboard="false" class="btn btn-default" href="#" data-toggle="modal" data-target="#pay" data-button="Tambah Data" data-title="Tambah Data Pembayaran"> Tambah Data </a>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                    <a data-backdrop="static" data-keyboard="false" class="btn btn-default" href="#" data-toggle="modal" data-target="#pay" data-button="Tambah Data" data-title="Tambah Data Pembayaran"> Tambah Data </a>
                </div>
                <div class="col-md-4 col-sm-8 col-xs-12">
                    {!! Form::open(array('route' => 'backend.payment.index', 'method' => 'get' )) !!}
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
            @include('widgets.backend.pageElements.headerSearchResult', ['closeSearchLink' => route('backend.payment.index') ])
            </br> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="col-md-2">Nota Transaksi</th>
                                    <th class="">Nama</th>
                                    <th class="">Bank</th>
                                    <th class="">Nomor Rekening</th>
                                    <th class="">Tanggal</th>
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
                                        <td>{{$data['name']}}</td>
                                        <td>{{$data['bank']}}</td>
                                        <td>{{$data['account_number']}}</td>
                                        <td>{{$data['date']}}</td>
                                        <td>
                                            <a href="{{ route('backend.courier.detail', ['courier_id' => $data['id']]) }}">Detail</a>,
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#pay" 
                                                data-id="{{ $data['id'] }}" 
                                                data-nota-transaksi="{{ $data['transaction']['invoice_no'] }}" 
                                                data-name="{{ $data['name'] }}" 
                                                data-bank="{{ $data['bank'] }}" 
                                                data-acc-no="{{ $data['account_number'] }}" 
                                                data-date="{{ $data['date'] }}" 
                                                data-title="Edit Data {{ $data['transaction']['invoice_no'] }}" 
                                                data-button="Simpan Data"
                                                href="#">
                                                Edit
                                            </a>,                                             
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#pay_del"
                                                data-id="{{$data['id']}}"
                                                data-title="Hapus Data Pembayaran {{$data['transaction']['invoice_no']}}" 
                                                data-button="Hapus Data"
                                                data-id="{{$data['id']}}"
                                                href="#">
                                                Hapus
                                            </a>                                            
                                        </td>    
                                    </tr>       
                                    <?php $ctr += 1; ?>                     
                                    @endforeach 
                                    @include('widgets.pageElements.formModal1', array('modal_id'=>'pay_del', 'modal_content' => 'pages.backend.payment.delete'))
                                @endif
                            </tbody>
                        </table> 
                    </div>                 
                </div>            	
            </div> 
        </div> 
    </div> 
</div>
@include('widgets.pageElements.formModal1', array('modal_id'=>'pay', 'modal_content' => 'pages.backend.payment.create'))                                    
@stop

@section('script')
    $('#pay_del').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).attr('data-id');
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');

        $('.mod_pwd').val('');
        $('.mod_id').val(id);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    }) 




    $('#pay').on('show.bs.modal', function (e) {
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');
        var id = $(e.relatedTarget).attr('data-id');
        var nota_transaksi = $(e.relatedTarget).attr('data-nota-transaksi');
        var name = $(e.relatedTarget).attr('data-name');
        var bank = $(e.relatedTarget).attr('data-bank');
        var acc_no = $(e.relatedTarget).attr('data-acc-no');
        var date = $(e.relatedTarget).attr('data-date');     

        $('.mod_id').val(id);
        $('.mod_nota_transaksi').val(nota_transaksi);
        $('.mod_name').val(name);
        $('.mod_bank').val(bank);
        $('.mod_acc_no').val(acc_no);
        $('.mod_date').val(date);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    })     
@stop