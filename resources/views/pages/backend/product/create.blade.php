@inject('data', 'App\Models\Product')
{!! $data = $data::where('id', $id)
            ->first(); 
!!}
@extends('template.backend.layout') 

@section('content')
    {!! Form::open(array('route' => 'backend.product.store')) !!}
        {!! Form::input('hidden', 'id', $data['id'], [
                    'class' => 'mod_id'
            ]) 
        !!}
        <div class="row">
            <div class="col-md-12">
                <h4 class="sub-header">
                    Produk
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Nama Produk</label>
                    {!! Form::text('name', $data['name'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '1', 
                                'placeholder'   => 'Masukkan nama produk'
                        ]) 
                    !!}
                </div>  
            </div> 
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sku">SKU Produk</label>
                    {!! Form::text('sku', $data['sku'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'placeholder'   => 'Masukkan kode SKU produk',
                                'tabindex'      => '2', 
                        ]) 
                    !!}
                </div>
            </div>                                         
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Deskripsi Produk</label>
                    {!! Form::textarea('description', $data['description'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'placeholder'   => 'Masukkan deskripsi produk',
                                'rows'          => '3',
                                'tabindex'      => '3',
                                'style'         => 'resize:none;',
                        ]) 
                    !!}
                </div>            
            </div>
        </div>
        </br>

        <div class="row">
            <div class="col-md-12">
                <h4 class="sub-header">
                    Kategori Produk
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="category">Kategori</label>
                    {!! 
                        Form::text(
                            'category',
                            null, 
                            [
                                'class'         => 'form-control', 
                                'rows'          => '3',
                                'tabindex'      => '3',
                                'id'            => 'find_category',
                                'style'         => 'resize:none;',
                            ] 
                        ) 
                    !!}
                </div>  
            </div> 
        </div>
        </br>

        <div class="row">
            <div class="col-md-12">
                <h4 class="sub-header">
                    Attribut Produk
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" id="add" class="btn btn-default">Tambah Attribute</a>
            </div>
        </div>
        </br>
        <div class="hidden">
            <div id="attributeTemplate">
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="form-group">
                            <label for="attribute[]">Attribut</label>
                            {!! 
                                Form::text(
                                    'attribute[]',
                                    null, 
                                    [
                                        'class'         => 'form-control', 
                                        'tabindex'      => '4', 
                                        'placeholder'   => 'Masukkan nama produk'
                                    ] 
                                ) 
                            !!}
                        </div>                 
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="form-group">
                            <label for="value[]">Nilai Attribut</label>
                            {!! 
                                Form::text(
                                    'value[]',
                                    null, 
                                    [
                                        'class'         => 'form-control', 
                                        'tabindex'      => '4', 
                                        'placeholder'   => 'Masukkan nama produk'
                                    ] 
                                ) 
                            !!}
                        </div>                 
                    </div> 
                    <div class="col-md-2 col-sm-2 col-xs-12" style="padding-top:24px;">
                        <button class="delete btn btn-default">Delete</button>                    
                    </div>
                    <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                        </br>
                        </br>
                    </div>           
                </div>
            </div>
        </div>
        <div id="items">
            @if(count($data['_attributes']) > 0 )
                @for ($i = 0; $i < count($data['_attributes']); $i++)
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group">
                                <label for="attribute[]">Attribut</label>
                                {!! 
                                    Form::text(
                                        'attribute[]',
                                        $data['_attributes'][$i]['attribute'], 
                                        [
                                            'class'         => 'form-control', 
                                            'tabindex'      => '4', 
                                            'placeholder'   => 'Masukkan nama produk'
                                        ] 
                                    ) 
                                !!}
                            </div>                 
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group">
                                <label for="value[]">Nilai Attribut</label>
                                {!! 
                                    Form::text(
                                        'value[]',
                                        $data['_attributes'][$i]['value'], 
                                        [
                                            'class'         => 'form-control', 
                                            'tabindex'      => '4', 
                                            'placeholder'   => 'Masukkan nama produk'
                                        ] 
                                    ) 
                                !!}
                            </div>                 
                        </div> 
                        <div class="col-md-2 col-sm-2 col-xs-12" style="padding-top:24px;">
                            <button class="delete btn btn-default">Delete</button>                    
                        </div>  
                        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                            </br>
                            </br>
                        </div>                                   
                    </div>
                @endfor
            @endif
        </div>

        <div class="row">
            <div class="col-md-12">
                </br>
                <div class="form-group text-right">
                    <a href="{{ URL::route('backend.product.index') }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
                    <button type="submit" class="btn btn-md btn-success" tabindex="7">Simpan</button>
                </div>        
            </div>        
        </div>        
    {!! Form::close() !!}   
@stop


@section('script')
    $( document ).ready(function() {
        var tmplt      =   $("#attributeTemplate").html();

        $("#items").append(tmplt);
    });


    $("#add").click(function (e) {
        var tmplt      =   $("#attributeTemplate").html();

        $("#items").append(tmplt);
    });

    $("body").on("click", ".delete", function (e) {
        $(this).parent("div").parent("div").remove();
    });    

    var preload_data = [];

    selections = [
        @if($data['_attributes'])
        @foreach($data['categories'] as $category)
            { 
                id:{{$category['id']}},
                text:'{{$category['name']}}'
            },
        @endforeach
        @endif
    ];

    for (i = 0; i < selections.length; i++) { 
        preload_data.push(selections[i]);         
    }

    $('#find_category').select2({
        placeholder: 'Masukkan nama kategori',
        minimumInputLength: 3,
        tags: false,
        ajax: {
            url: '/cms/ajax/get-category',
            dataType: 'json',
            data: function (term, path) {
                return {
                    name: term,
                    path : '{{$data['path']}}'
                };
            },
           results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name +' ',
                            id: item.id +' ',
                            path: item.path
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
    $('#find_category').select2('data', preload_data );       
@stop