@extends('template.backend.layout') 

@section('content')
    {!! Form::open(array('route' => 'backend.discount.save')) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product" class="text-capitalize">Produk</label>
                    {!! 
                        Form::text(
                            'product',
                            $data['parent_id'], 
                            [
                                'class'         => 'form-control', 
                                'tabindex'      => '1', 
                                'id'            => 'find_product',
                                'placeholder'   => 'Kosongkan bila tidak ada'
                            ] 
                        ) 
                    !!}
                </div>              
                <div class="form-group">
                    <label for="promo_price" class="text-capitalize">Harga Promo</label>
                    {!! 
                        Form::text(
                            'promo_price', 
                            null, 
                            [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '2',
                                'placeholder'   => 'Masukkan harga'
                            ] 
                        ) 
                    !!}
                </div>
                <div class="form-group">
                    <label for="start_date" class="text-capitalize">Tanggal Mulai</label>
                    {!! 
                        Form::input(
                            'date',
                            'start_date', 
                            null, 
                            [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '3',
                                'placeholder'   => 'Tanggal berlaku harga'
                            ] 
                        ) 
                    !!}
                </div>
                <div class="form-group">
                    <label for="end_date" class="text-capitalize">Tanggal Akhir</label>
                    {!! 
                        Form::input(
                            'date',
                            'end_date', 
                            null, 
                            [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '4',
                                'placeholder'   => 'Tanggal berakhir harga'
                            ] 
                        ) 
                    !!}
                </div>                              
                </br>
                <div class="form-group text-right">
                    <a href="{{ URL::route('backend.discount.index') }}" class="btn btn-md btn-default" tabindex="5">Batal</a>
                    <button type="submit" class="btn btn-md btn-success" tabindex="6">Simpan</button>
                </div>
            </div>                                          
        </div>
    {!! Form::close() !!}
@stop

@section('script')
    @if($data['parent_id'])
        var preload_data = [];
        var id = {!! $data['parent_id'] !!};
        var text = "{!! $data['product']['name'] !!}";
        preload_data.push({ id: id, text: text});
    @else
        var preload_data = [];
    @endif

    $('#find_product').select2({
        placeholder: 'Masukkan sku produk',
        minimumInputLength: 3,
        maximumSelectionSize : 1,
        tags: false,
        ajax: {
            url: '/cms/ajax/get-product',
            dataType: 'json',
            data: function (term) {
                return {
                    name: term,
                };
            },
           results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.sku +' - ' + item.name,
                            id: item.id,
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
    $('#find_product').select2('data', preload_data );  
@stop