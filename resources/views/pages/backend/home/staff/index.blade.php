@inject('transaction', 'App\Models\Transaction')
@inject('store', 'App\Models\StoreSetting')
@inject('td', 'App\Models\TransactionDetail')

<?php 
$expired                = $store->ondate('now')->type('expired_paid')->first();
$critical               = $store->ondate('now')->type('critical_stock')->first();
$trs                    = $transaction->type('sell')->transactionlogchangedat([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), '+ 7 hours'])->status(['paid', 'shipping'])->get();
$wait                   = $transaction->type('sell')->transactionlogchangedat([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), '+ 7 hours'])->status('wait')->count();
$canceled               = $transaction->type('sell')->ondate($expired)->status('wait')->get();
$stocks                 = $td->critical((0 - $critical->value))->with(['varian', 'varian.product'])->get();
?>

@extends('template.backend.layout') 

@section('content')
    <div class="row">
        @if($trs->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="4">Transaksi yang harus ditangani</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trs as $data)
                            <tr>
                                <td class="text-left"><a href="{{route('backend.data.transaction.show', ['id' => $data['transaction_id'], 'type' => 'sell'])}}">{{$data['ref_number']}}</a></td>
                                <td>{{ $data['user']['name'] }}</td>
                                <td class="text-center">@money_indo($data['amount']) </td>
                                <td>
                                    @if($data['status']=='wait')
                                        <a href="{{route('backend.data.sell.getpaid', $data['id'])}}">Proses Selanjutnya</a>
                                    @elseif($data['status']=='paid')
                                        <a href="{{route('backend.data.shipment.edit', $data['shipment']['id'])}}">Proses Selanjutnya</a>
                                    @elseif($data['status']=='shipping')
                                        <a href="{{route('backend.data.transaction.status', [$data['id'], 'status' => 'delivered'])}}">Proses Selanjutnya</a>
                                    @endif
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($canceled->count())
        <div class="col-sm-6">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th colspan="4">Transaksi yang harus dibatalkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($canceled as $data)
                        <tr>
                            <td class="text-left"><a href="{{route('backend.data.transaction.show', ['id' => $data['transaction_id'], 'type' => 'sell'])}}">{{$data['ref_number']}}</a></td>
                            <td>{{ $data['user']['name'] }}</td>
                            <td class="text-center">@money_indo($data['amount']) </td>
                            <td>
                                <a href="{{route('backend.data.transaction.status', [$data['id'], 'status' => 'canceled'])}}">Proses Selanjutnya</a>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table> 
            </div>
        </div>
        @endif

        @if($wait)
        <div class="col-sm-6">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th colspan="4">Nota bayar baru</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center">
                                {!! Form::open(['url' => route('backend.data.sell.getpaid'), 'method' => 'GET']) !!}
                                    <div class="form-group">
                                        {!! Form::text('trs_id', null, [
                                                    'class'         => 'select-transaction', 
                                                    'id'            => 'find_transaction',
                                                    'tabindex'      => '1',
                                                    'placeholder'   => 'Masukkan jumlah transfer',
                                                    'style'         => 'width:100%',
                                        ]) !!}
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-md btn-primary" tabindex="2">Cek</button>
                                    </div>
                                {!!Form::close()!!}
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>
        @endif

        @if ($stocks->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="4">Barang yang harus di restock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($canceled as $data)
                            <tr>
                                <td class="text-left"><a href="{{route('backend.data.transaction.show', ['id' => $data['transaction_id'], 'type' => 'sell'])}}">{{$data['ref_number']}}</a></td>
                                <td>{{ $data['user']['name'] }}</td>
                                <td class="text-center">@money_indo($data['amount']) </td>
                                <td>
                                    <a href="{{route('backend.data.transaction.create', ['type' => 'sell'])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif
        @if(!$trs->count() && !$canceled->count() && !$wait && !$stocks->count())
            <div class="col-sm-12 text-center">
                <h3>There is nothing to do</h3>
                <h2>Keep your dashboard clean</h2>
            </div>
        @endif
    </div>
@stop

@section('script')
    var preload_data = [];
@stop

@section('script_plugin')
    @include('plugins.select2')
@stop