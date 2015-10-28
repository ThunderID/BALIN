@extends('template.backend.layout')

@section('content')
<div class="container-fluid">
	@include('widgets.backend.pageelements.pageTitle')
    @include('widgets.backend.pageelements.breadcrumb')
    @include('widgets.backend.pageelements.alertBox')

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
		        <div class="col-md-6">
		            <div class="row">
		            	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img class="imageCard" src="http://placehold.it/320x150" alt="" style="width:100px;height:100px;">
		            	</div>
		            	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-8">
		            		<div class="row">
								<div class="col-md-3 col-sm-4 col-xs-4">
				            		Nama :
				            	</div>
				            	<div class="col-md-7 col-sm-8 col-xs-8">
				            		{{ $data['name'] }}
				            	</div>		            			
		            		</div>
				            <div class="row">
								<div class="col-md-3 col-sm-4 col-xs-4">
				            		Status :
				            	</div>
				            	<div class="col-md-7 col-sm-8 col-xs-8">
                                    @if($data['status'] == 0)
                                        Tidak Aktif
                                    @elseif($data['status'] == 1)
                                        Aktif
                                    @else
                                        N.a
                                    @endif  
				            	</div>
							</div>	           		
		            	</div>
					</div>				
		        </div>
		        <div class="col-md-6">
		        	<div class="row">
		        		<div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#cou_del" class="btn btn-default pull-right"
                                data-title="Hapus Data Kurir {{$data['name']}}" 
                                data-button="Hapus Data"
                                href="#">
                                Hapus
                            </a>
                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#cou" class="btn btn-default pull-right"
                                data-id="{{ $data['id'] }}" 
                                data-name="{{ $data['name'] }}" 
                                data-status="{{ $data['status'] }}" 
                                data-title="Edit Data {{$data['name']}}" 
                                data-button="Simpan Data"
                                href="#">
                                Edit
                            </a>		                    
		        		</div>
		        	</div>
		        </div>
            </div>
        </div>
    </div>
	</br>
	@include('pages.backend.menu-shipping.courier.courierBranch.index')
</div>
@include('widgets.pageelements.formModal1', array('modal_id'=>'cou_del', 'modal_content' => 'pages.backend.menu-shipping.courier.delete', 'mod_btn_type' => 'danger'))
@include('widgets.pageelements.formModal1', array('modal_id'=>'cou', 'modal_content' => 'pages.backend.menu-shipping.courier.create', 'mod_btn_type' => 'success'))
@stop