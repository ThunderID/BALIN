@inject('data', 'App\Models\Supplier')
<?php 
    $data = $data::find($id);
?>

@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.data.supplier.update', $id), 'method' => 'PATCH']) !!}
    @else
        {!! Form::open(['url' => route('backend.data.supplier.store'), 'method' => 'POST']) !!}
    @endif
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="text-capitalize">Nama</label>
                    {!! Form::text('name',$data['name'], [
                                'class'         => 'form-control', 
                                'tabindex'      => '1', 
                                'required'      => 'required', 
                                'placeholder'   => 'Masukkan nama supplier'
                    ]) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone" class="text-capitalize">Nomor Telepon</label>
                    {!! Form::text('phone', $data['phone'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '2',
                                'placeholder'   => 'Masukkan nomor telepon'
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address" class="text-capitalize">Alamat</label>
                    {!! Form::textarea('address',  $data['address'], [
                                'class'         => 'form-control',
                                'rows'          => '3', 
                                'required'      => 'required',
                                'tabindex'      => '3',
                                'style'         => 'resize:none;',
                                'placeholder'   => 'Masukkan alamat lengkap'
                    ]) !!}
                </div>                 
                <div class="clearfix">&nbsp;</div>
                <div class="form-group text-right">
                    <a href="{{ URL::route('backend.data.supplier.index') }}" class="btn btn-md btn-default" tabindex="4">Batal</a>
                    <button type="submit" class="btn btn-md btn-primary" tabindex="5">Simpan</button>
                </div>
            </div>                                          
        </div>
    {!! Form::close() !!}
@stop
