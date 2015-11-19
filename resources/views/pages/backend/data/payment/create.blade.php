@inject('data', 'App\Models\Payment')
<?php 
    $data = $data::findornew($id);
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
            <div class="col-md-12">
                <div class="form-group">
                    <label for="amount" class="text-capitalize">Jumlah Transfer</label>
                    {!! Form::text('transaction', $data['transaction_id'], [
                                'class'         => 'select-transaction', 
                                'id'            => 'find_transaction',
                                'tabindex'      => '3',
                                'placeholder'   => 'Masukkan jumlah transfer',
                                'style'         => 'width:100%',
                    ]) !!}
                </div>
            </div>
        </div>                        
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
                    <label for="destination" class="text-capitalize">Dikirim ke (Nama Bank)</label>
                    {!! Form::text('destination', $data['destination'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '5',
                                'placeholder'   => 'Masukkan nama bank'
                    ]) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ondate" class="text-capitalize">Tanggal Bayar</label>
                    {!! Form::text('ondate', (!is_null($data['ondate']) ? $data['ondate']->format('Y-m-d') : ''), [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '6',
                                'placeholder'   => 'yyyy-mm-dd'
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="clearfix">&nbsp;</div>
                <div class="form-group text-right">
                    <a href="{{ URL::route('backend.data.payment.index') }}" class="btn btn-md btn-default" tabindex="7">Batal</a>
                    <button type="submit" class="btn btn-md btn-primary" tabindex="8">Simpan</button>
                </div>
            </div>                                          
        </div>
    {!! Form::close() !!}
@stop

@section('script')
    @if(!$transaction)
        var preload_data = [];
    @else
        var preload_data = [{"id": {{$transaction['id']}}, "text":"{{$transaction['user']['name'].' #'.$transaction['ref_number'].' ('.$transaction['amount'].')'}}"}];
    @endif
@stop

@section('script_plugin')
    @include('plugins.select2')
@stop