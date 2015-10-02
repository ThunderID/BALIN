@extends('template.backend.layout') 

@section('content')
    {!! Form::open(array('route' => 'backend.category.save')) !!}
        {!!
            Form::input(
                'hidden', 
                'id', 
                $data['id'],  
                [
                    'class' => 'mod_id'
                ]
            ) 
        !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="parent" class="text-capitalize">Termasuk dalam Kategori</label>
                    {!! 
                        Form::text(
                            'parent',
                            $data['parent_id'], 
                            [
                                'class'         => 'form-control', 
                                'tabindex'      => '1', 
                                'id'            => 'find_category',
                                'placeholder'   => 'Kosongkan bila tidak ada'
                            ] 
                        ) 
                    !!}
                </div>              
                <div class="form-group">
                    <label for="name" class="text-capitalize">Nama Kategori</label>
                    {!! 
                        Form::text(
                            'name', 
                            $data['name'], 
                            [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '2',
                                'placeholder'   => 'Masukkan nama kategori'
                            ] 
                        ) 
                    !!}
                </div>   
                </br>
                <div class="form-group text-right">
                    <a href="{{ URL::route('backend.category.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
                    <button type="submit" class="btn btn-md btn-success" tabindex="4">Simpan</button>
                </div>
            </div>                                          
        </div>
    {!! Form::close() !!}
@stop

@section('script')
    @if($data['parent_id'])
        var preload_data = [];
        var id = {!! $data['parent_id'] !!};
        var text = "{!! $data['category']['name'] !!}";
        preload_data.push({ id: id, text: text});
    @else
        var preload_data = [];
    @endif

    $('#find_category').select2({
        placeholder: 'Masukkan nama kategori',
        minimumInputLength: 3,
        maximumSelectionSize : 1,
        tags: false,
        ajax: {
            url: '/cms/ajax/get-categoryParent',
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