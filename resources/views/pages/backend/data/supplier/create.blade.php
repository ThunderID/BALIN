@inject('data', 'App\Models\Supplier')
@if ($id)
    <?php $data = $data::find($id); ?>
@endif

@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.data.supplier.update', $id), 'method' => 'PATCH']) !!}
    @else
        {!! Form::open(['url' => route('backend.data.supplier.store'), 'method' => 'POST']) !!}
    @endif
        {!! Form::hidden('address_id',$data['address']['id']) !!}    
        <div class="row">
            <div class="col-md-12">
                <h4 class="sub-header">
                    Data
                </h4>
            </div>
        </div>    
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="text-capitalize">Nama Supplier</label>
                    {!! Form::text('name',$data['name'], [
                                'class'         => 'form-control', 
                                'tabindex'      => '1', 
                                'required'      => 'required', 
                                'placeholder'   => 'Masukkan nama supplier'
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4 class="sub-header">
                    Alamat
                </h4>
            </div>
        </div>          
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone" class="text-capitalize">Nomor Telepon</label>
                    {!! Form::text('phone', $data['address']['phone'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '2',
                                'placeholder'   => 'Masukkan nomor telepon'
                    ]) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone" class="text-capitalize">Kode Pos</label>
                    {!! Form::text('zipcode', $data['address']['zipcode'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '3',
                                'placeholder'   => 'Masukkan kode pos'
                    ]) !!}
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address" class="text-capitalize">Alamat</label>
                    {!! Form::textarea('address',  $data['address']['address'], [
                                'class'         => 'form-control',
                                'rows'          => '3', 
                                'required'      => 'required',
                                'tabindex'      => '4',
                                'style'         => 'resize:none;',
                                'placeholder'   => 'Masukkan alamat lengkap'
                    ]) !!}                    
                </div>                                 
            </div>            
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="clearfix">&nbsp;</div>
                <div class="form-group text-right">
                    <a href="{{ URL::route('backend.data.supplier.index') }}" class="btn btn-md btn-default" tabindex="4">Batal</a>
                    <button type="submit" class="btn btn-md btn-primary" tabindex="5">Simpan</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@stop
