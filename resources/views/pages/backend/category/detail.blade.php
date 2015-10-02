@extends('template.backend.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="row">
                <h3 class="text-capitalize">Informasi Kategori</h3>
                <div class="row">
                    <div class="col-md-4 text-left">
                        <p class="text-capitalize">Nama Kategori<span class="pull-right">:</span></p>
                    </div>
                    <div class="col-md-8">
                        <p class="text-capitalize">{{ $data['name'] }}</p>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-4 text-left">
                        <p class="text-capitalize">Prefix Kategori<span class="pull-right">:</span></p>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $data['prefix'] }}</p>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-4 text-left">
                        <p class="text-capitalize">Jumlah Produk<span class="pull-right">:</span></p>
                    </div>
                    <div class="col-md-8">
                        <p>{{ count($data['products']) }}</p>
                    </div>
                </div>                                                        
                <div class="row">
                    <div class="col-md-10 text-right">
                        <a href="#" >Edit</a> 
                        |                                                                                  
                        <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#category_del"
                            data-id="{{$data['id']}}"
                            data-title="Hapus Data Kategori {{$data['name']}}">
                            Hapus
                        </a>                                                                                                               
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</br>
@include(
    'widgets.pageElements.formModalDelete', 
    array(
        'modal_id'      => 'category_del', 
        'modal_route'   => 'backend.category.delete'
        )
    )

@if(count($data['products']) == 0)
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-capitalize">Data produk dalam kategori ini</h3>
             Tidak ada data
             </br>
             </br>
         </div>
     </div>
@else
    <div class="table-responsive">
        <h3 class="text-capitalize">Data produk dalam kategori ini</h3>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Nama</th>
                    <th>Brand</th>
                    <th>Kontrol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['products'] as $product)
                    <tr>
                        <td>{{ $product['sku'] }}</td>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['brand'] }}</td>
                        <td> 
                            <a href="#"> Detail </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>  
@endif         
@Stop