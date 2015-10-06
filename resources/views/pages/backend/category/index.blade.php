@extends('template.backend.layout') 

@section('content')
	<div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-8 col-sm-4 hidden-xs">
                    <a class="btn btn-default" href="{{ URL::route('backend.category.create') }}"> Data Baru </a>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                    <a class="btn btn-default btn-block" href="{{ URL::route('backend.category.create') }}"> Data Baru </a>
                </div>
<!--                 <div class="col-md-4 col-sm-8 col-xs-12">
                    {!! Form::open(array('route' => 'backend.category.index', 'method' => 'get' )) !!}
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
                </div>   -->          
            </div>
            @include('widgets.backend.pageElements.headerSearchResult', ['closeSearchLink' => route('backend.category.index') ])
            </br> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2">Nama Kategori</th>
                                    <th>Kontrol</th>
                                </tr>
                            </thead>                            
                            <tbody>
                                @if(count($datas) == 0)
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @else                                                                                           
                                    @foreach($datas as $data)
                                    <tr>
                                        <td>
                                            @if($data['parent_id'] == 0)
                                                <i class="fa fa-circle"></i>
                                            @endif
                                        </td>
                                        <td class="col-md-10">
                                            <p class="text-capitalize">
                                                @for ($i = 0; $i < substr_count($data['path'],','); $i++)
                                                    &nbsp;
                                                @endfor
                                                {{$data['name']}}
                                            </p>
                                        </td>
                                        <td>
                                            <a href="{{ url::route('backend.category.show',  $data['id']) }}"> Detail </a>,
                                            <a href="{{ url::route('backend.category.edit', ['id' => $data['id']]) }}"> Edit </a>, 
                                            <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#category_del"
                                                data-id="{{$data['id']}}"
                                                data-title="Hapus Data Kategori {{$data['name']}}">
                                                Hapus
                                            </a>                                                                                      
                                        </td>    
                                    </tr>
                                    @endforeach 
                                    @include(
                                        'widgets.pageElements.formModalDelete', 
                                        array(
                                            'modal_id'      => 'category_del', 
                                            'modal_route'   => 'backend.category.destroy'
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