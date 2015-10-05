@extends('template.backend.layout') 

@section('content')
	<div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-8 col-sm-4 hidden-xs">
                    <a class="btn btn-default" href="{{ URL::route('backend.discount.create') }}"> Data Baru </a>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                    <a class="btn btn-default btn-block" href="{{ URL::route('backend.discount.create') }}"> Data Baru </a>
                </div>
                <div class="col-md-4 col-sm-8 col-xs-12">
                    {!! Form::open(array('route' => 'backend.discount.index', 'method' => 'get' )) !!}
                    <div class="row">
                        <div class="col-md-2 col-sm-3 hidden-xs">
                        </div>
                        <div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
                            {!!
                                Form::input(
                                    'text', 
                                    'q', 
                                    Null ,
                                    [
                                        'class'         => 'form-control',
                                        'placeholder'   => 'Cari sesuatu',
                                        'required'      => 'required',
                                        'style'         =>'text-align:right'
                                    ]
                                )
                            !!}                                          
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
                            <button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>            
            </div>
            @include('widgets.backend.pageElements.headerSearchResult', ['closeSearchLink' => route('backend.discount.index') ])
            </br> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="col-md-3">SKU</th>
                                    <th class="col-md-3">Diskon</th>
                                    <th class="col-md-2">Tanggal Mulai</th>
                                    <th class="col-md-2">Tanggal Akhir</th>
                                    <th>Kontrol</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($datas) == 0)
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @else                                                                 
	                                <?php
	                                    $nop = ($datas->currentPage() - 1) * 15;
	                                    $ctr = 1 + $nop;
	                                ?> 
                                    @foreach($datas as $data)
                                    <tr>
                                        <td>{{$ctr}}</td>
                                        <td>{{$data['sku']}}</td>
                                        <td>
                                            @if(isset($data['discount']['promo_price']))
                                                {{$data['discount']['promo_price']}}
                                            @else
                                                _
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($data['discount']['start_date']))
                                                {{$data['discount']['start_date']}}
                                            @else
                                                _
                                            @endif
                                        </td> 
                                        <td>
                                            @if(isset($data['discount']['end_date']))
                                                {{$data['discount']['end_date']}}
                                            @else
                                                _
                                            @endif
                                        </td>                                                                                                                        
                                        <td>
                                            <a href="#"> Detail </a>,
                                            <a href="#"> Update </a>
                                        </td>    
                                    </tr>       
                                    <?php $ctr += 1; ?>                     
                                    @endforeach 
                                    @include(
                                        'widgets.pageElements.formModalDelete', 
                                        array(
                                            'modal_id'      => 'discount_del', 
                                            'modal_route'   => 'backend.discount.delete'
                                            )
                                        )
                                @endif
                            </tbody>
                        </table> 
                    </div>                 
                </div>
            </div>
	        @if(count($datas) > 0)
	            <div class="row">
	                <div class="col-md-12" style="text-align:right;">
	                    {!! $datas->appends(Input::all())->render() !!}
	                </div>
	            </div>
            @endif
        </div>
    </div>
@stop