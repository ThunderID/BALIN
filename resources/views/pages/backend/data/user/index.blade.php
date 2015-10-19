@inject('datas', 'App\Models\User')
{!! $datas= $datas::paginate() !!}

@extends('template.backend.layout')

@section('content')
<div class="container-fluid">
	<div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-8 col-sm-4 hidden-xs">
                    <a class="btn btn-default" href="{{ route('backend.user.create') }}"> Data Baru </a>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                </div>
                <div class="col-md-4 col-sm-8 col-xs-12">
                    {!! Form::open(array('route' => 'backend.user.index', 'method' => 'get' )) !!}
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
            @include('widgets.backend.pageElements.headerSearchResult', ['closeSearchLink' => route('backend.user.index') ])
            </br> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="col-md-3">Nama</th>
                                    <th class="col-md-3">Nomor Telepon</th>
                                    <th class="col-md-4">Alamat</th>
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
                                        <td>{{$data['name']}}</td>
                                        <td>{{$data['phone']}}</td>
                                        <td>{{$data['address']}}</td>
                                        <td>
                                            <a href="">Detail</a>,
                                            <a href="{{ route('backend.user.edit', $data['id']) }}">Edit</a>, 
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#cus_del"
                                                data-id="{{$data['id']}}"
                                                data-title="Hapus Data user {{$data['name']}}" 
                                                data-button="Hapus Data"
                                                data-id="{{$data['id']}}"
                                                href="#">
                                                Hapus
                                            </a>                                            
                                        </td>    
                                    </tr>       
                                    <?php $ctr += 1; ?>                     
                                    @endforeach 
                                    @include('widgets.pageElements.formModal1', array('modal_id'=>'cus_del', 'modal_content' => 'pages.backend.data.user.delete'))
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
@stop

@section('script')
    $('#cus_del').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).attr('data-id');
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');

        $('.mod_pwd').val('');
        $('.mod_id').val(id);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    }) 

    $('#cus').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).attr('data-id');
        var name = $(e.relatedTarget).attr('data-name');
        var gender = $(e.relatedTarget).attr('data-gender');
        var dob = $(e.relatedTarget).attr('data-dob');
        var email = $(e.relatedTarget).attr('data-email');
        var phone = $(e.relatedTarget).attr('data-phone');
        var address = $(e.relatedTarget).attr('data-address');
        var zip = $(e.relatedTarget).attr('data-zip');

        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');
        $('.mod_id').val(id);
        $('.mod_name').val(name);
        $('.mod_gender').val(gender);
        $('.mod_dob').val(dob);
        $('.mod_email').val(email);
        $('.mod_phone').val(phone);
        $('.mod_address').val(address);
        $('.mod_zip').val(zip);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    })     
@stop