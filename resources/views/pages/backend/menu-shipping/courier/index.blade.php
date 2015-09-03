@extends('template.backend.layout')

@section('content')
<div class="container-fluid">
	@include('widgets.backend.pageElements.pageTitle')
    @include('widgets.backend.pageElements.breadcrumb')
    @include('widgets.backend.pageElements.alertBox')
	<div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-8">
                    <a class="btn btn-default"href="#}"> Data Baru </a>
                    <a class="btn btn-danger"href="#"> Button 2 </a>
                    <a class="btn btn-warning"href="#"> Button 3 </a>
                    <a class="btn btn-success"href="#"> Button 4 </a>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-8" style="padding-right:2px;">
                            {!!Form::input('text', 'q', Null , ['class' => 'form-control', 'placeholder' => 'Cari sesuatu', 'required' => 'required', 'style'=>'text-align:right']) !!}                                          
                        </div>
                        <div class="col-md-3" style="padding-left:2px;">
                            <button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
                        </div>
                    </div>
                </div>            
            </div>
            </br> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-1">No.</th>
                                    <th class="col-md-6">Nama</th>
                                    <th class="col-md-2">Status</th>
                                    <th class="col-md-3">Kontrol</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr>
                                    <td>1.</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                ad
                                            </div>
                                            <div class="col-sm-10">
                                                afd
                                            </div>
                                        </div>
                                    </td>
                                    <td>Aktif</td>
                                    <td>
                                        <a href="#">Detail</a>,
                                        <a href="#">Edit</a>,
                                        <a href="#">Hapus</a>
                                    </td>    
                                </tr>                      
                            </tbody>
                        </table> 
                    </div>                 
                </div>
            </div>
        </div>
    </div>

</div>
@stop