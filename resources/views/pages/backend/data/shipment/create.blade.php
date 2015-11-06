@inject('data', 'App\Models\Shipment')
<?php 
    $data = $data::findornew($id);
?>

@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.data.shipment.update', $id), 'method' => 'PATCH']) !!}
    @else
        {!! Form::open(['url' => route('backend.data.shipment.store'), 'method' => 'POST']) !!}
    @endif
        <label for="method" class="text-capitalize">Resi Pengiriman {{$data['transaction']['ref_number']}}</label>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="receipt_number" class="text-capitalize">Nomor Resi</label>
                    {!! Form::text('receipt_number',$data['receipt_number'], [
                                'class'         => 'form-control', 
                                'tabindex'      => '1', 
                                'required'      => 'required', 
                                'placeholder'   => 'Masukkan nomor resi'
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="clearfix">&nbsp;</div>
                <div class="form-group text-right">
                    <a href="{{ URL::route('backend.data.shipment.index') }}" class="btn btn-md btn-default" tabindex="2">Batal</a>
                    <button type="submit" class="btn btn-md btn-primary" tabindex="3">Simpan</button>
                </div>
            </div>                                          
        </div>
    {!! Form::close() !!}
@stop
