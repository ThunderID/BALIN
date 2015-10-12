@inject('data', 'App\Models\Category')

@if ($id)
    {!! $data = $data::with('category')->where('categories.id', $id)->first(); !!}
@endif

@extends('template.backend.layout') 

@section('content')
    {!! Form::open(array('route' => 'backend.category.store')) !!}
        {!! Form::input('hidden', 'id', $data['id'], ['class' => 'mod_id']) !!}
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="parent" class="text-capitalize">Termasuk dalam Kategori</label>
                    {!! Form::text('parent', $data['parent_id'], [
                                'class'         => 'form-control', 
                                'tabindex'      => '1', 
                                'id'            => 'find_category',
                                'placeholder'   => 'Kosongkan bila tidak ada'
                    ]) !!}
                </div>              
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="name" class="text-capitalize">Nama Kategori</label>
                    {!! Form::text('name', $data['name'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '2',
                                'placeholder'   => 'Masukkan nama kategori'
                    ]) !!}
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

    
@stop