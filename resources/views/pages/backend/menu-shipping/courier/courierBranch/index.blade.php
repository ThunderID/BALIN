<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Kantor cabang</h3>
	</div>
</div>
<div class="row">
    <div class="col-md-8 col-sm-4 hidden-xs">
        <a data-backdrop="static" data-keyboard="false" class="btn btn-default" href="#" data-toggle="modal" data-target="#cou_branch" data-button="Tambah Data" data-title="Tambah Data Kantor Cabang {{ $data['name'] }}"> Data Baru </a>
    </div>
    <div class="hidden-lg hidden-md hidden-sm col-xs-12">
        <a data-backdrop="static" data-keyboard="false" class="btn btn-default btn-block" href="#" data-toggle="modal" data-target="#cou_branch" data-button="Tambah Data" data-title="Tambah Data Kantor Cabang {{ $data['name'] }}"> Data Baru </a>
    </div>       
    <div class="col-md-4 col-sm-8 col-xs-12">
        {!! Form::open(array('route' => 'backend.courier.detail', 'method' => 'get' )) !!}
        {!! Form::input('hidden', 'courier_id', $data['id']) !!}                                          
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
@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.courier.detail', ['courier_id' => $data['id']] )])
</br> 
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th class="col-md-3">Nama Cabang</th>
                        <th class="col-md-1">Status</th>
                        <th class="col-md-2">Nomor Telepon</th>
                        <th class="col-md-4">Alamat</th>
                        <th>Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    <tbody>
                        <?php
                            $nop = ($data_branches->currentPage() - 1) * 15;
                            $ctr = 1 + $nop;
                        ?>

                        @if(count($data_branches) == 0)
                            <tr>
                                <td colspan="6" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @else
                            @foreach($data_branches as $data_branch)
                            <tr>
                                <td>{{$ctr}}</td>
                                <td>{{$data_branch['name']}}</td>
                                <td>
                                    @if($data_branch['status'] == 0)
                                        Tidak Aktif
                                    @elseif($data_branch['status'] == 1)
                                        Aktif
                                    @else
                                        N.a
                                    @endif                                    
                                </td>
                                <td>{{$data_branch['phone']}}</td>
                                <td>{{$data_branch['address']}}</td>
                                <td>
                                    <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#cou_branch" 
                                        data-id="{{ $data_branch['id'] }}" 
                                        data-name="{{ $data_branch['name'] }}" 
                                        data-status="{{ $data_branch['status'] }}" 
                                        data-phone="{{ $data_branch['phone'] }}" 
                                        data-address="{{ $data_branch['address'] }}" 
                                        data-title="Edit Data Kantor Cabang {{$data_branch['name']}}" 
                                        data-button="Simpan Data"
                                        href="#">
                                        Edit
                                    </a>,
                                    <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#cou_branch_del" 
                                        data-id="{{ $data_branch['id'] }}" 
                                        data-title="Hapus Data Kantor Cabang {{$data_branch['name']}}" 
                                        data-button="Hapus Data"
                                        href="#">
                                        Hapus
                                    </a>
                                </td>    
                            </tr> 
                            <?php $ctr += 1; ?>                     
                            @endforeach 
                        @endif
                    </tbody>                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="text-align:right;">
        {!! $data_branches->appends(Input::all())->render() !!}
    </div>
</div>


@include('widgets.pageelements.formModal1', array('modal_id'=>'cou_branch', 'modal_content' => 'pages.backend.menu-shipping.courier.courierBranch.create' ))
@include('widgets.pageelements.formModal1', array('modal_id'=>'cou_branch_del', 'modal_content' => 'pages.backend.menu-shipping.courier.courierBranch.delete' ))


@section('script')
    $('#cou_branch').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).attr('data-id');
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');
        var name = $(e.relatedTarget).attr('data-name');
        var status = $(e.relatedTarget).attr('data-status');
        var phone = $(e.relatedTarget).attr('data-phone');
        var address = $(e.relatedTarget).attr('data-address');

        $('.mod_id').val(id);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
        $('.mod_name').val(name);
        $('.mod_status').val(status);
        $('.mod_phone').val(phone);
        $('.mod_address').val(address);
    })

    $('#cou_branch_del').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).attr('data-id');
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');

        $('.mod_id').val(id);
        $('.mod_pwd').val('');
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    })   

    $('#cou_del').on('show.bs.modal', function (e) {
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');

        $('.mod_pwd').val('');
        $('.mod_title').html(title);
        $('.mod_button').html(button);
    })      

    $('#cou').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).attr('data-id');
        var title = $(e.relatedTarget).attr('data-title');
        var button = $(e.relatedTarget).attr('data-button');
        var name = $(e.relatedTarget).attr('data-name');
        var status = $(e.relatedTarget).attr('data-status');

        $('.mod_id').val(id);
        $('.mod_title').html(title);
        $('.mod_button').html(button);
        $('.mod_name').val(name);
        $('.mod_status').val(status);
    })

@stop