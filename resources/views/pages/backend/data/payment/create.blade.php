@inject('data', 'App\Models\Payment')
<?php 
    $data = $data::find($id);
?>

@extends('template.backend.layout') 

@section('content')
    @if(!is_null($id))
        {!! Form::open(['url' => route('backend.data.payment.update', $id), 'method' => 'PATCH']) !!}
    @else
        {!! Form::open(['url' => route('backend.data.payment.store'), 'method' => 'POST']) !!}
    @endif
        <label for="method" class="text-capitalize">Bank Transfer</label>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="account_name" class="text-capitalize">Nama Akun</label>
                    {!! Form::text('account_name',$data['account_name'], [
                                'class'         => 'form-control', 
                                'tabindex'      => '1', 
                                'required'      => 'required', 
                                'placeholder'   => 'Masukkan nama akun'
                    ]) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="account_number" class="text-capitalize">Nomor Akun</label>
                    {!! Form::text('account_number', $data['account_number'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '2',
                                'placeholder'   => 'Masukkan nomor akun'
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="amount" class="text-capitalize">Jumlah Transfer</label>
                    {!! Form::text('amount', $data['amount'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '3',
                                'placeholder'   => 'Masukkan jumlah transfer'
                    ]) !!}
                </div>
            </div>                                          
            <div class="col-md-6">
                <div class="form-group">
                    <label for="destination" class="text-capitalize">Dikirim ke (Nama Bank)</label>
                    {!! Form::text('destination', $data['destination'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '4',
                                'placeholder'   => 'Masukkan nama bank'
                    ]) !!}
                </div>
            </div>
        </div>                        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="ondate" class="text-capitalize">Tanggal Bayar</label>
                    {!! Form::text('ondate', $data['ondate'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '5',
                                'placeholder'   => 'yyyy-mm-dd'
                    ]) !!}
                </div>
                <div class="clearfix">&nbsp;</div>
                <div class="form-group text-right">
                    <a href="{{ URL::route('backend.data.payment.index') }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
                    <button type="submit" class="btn btn-md btn-primary" tabindex="5">Simpan</button>
                </div>
            </div>                                          
        </div>
    {!! Form::close() !!}
@stop
