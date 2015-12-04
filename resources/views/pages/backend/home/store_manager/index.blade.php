@inject('product', 'App\Models\Product')
@inject('store', 'App\Models\StoreSetting')
@inject('transaction', 'App\Models\Transaction')
@inject('store', 'App\Models\StoreSetting')
@inject('td', 'App\Models\TransactionDetail')

<?php 
$margin                 = $store->ondate('now')->type('min_margin')->first();
$margins                = $product->margin($margin->value)->get();
$negatives              = $transaction->frequentnegative([( !is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null ), 'now'])->get();
$positives              = $transaction->frequentpositive([( !is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null ), 'now'])->get();
$bought                 = $transaction->ondate([( !is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null ), 'now'])->type('buy')->status('delivered')->get();
$expired                = $store->ondate('now')->type('expired_paid')->first();
$critical               = $store->ondate('now')->type('critical_stock')->first();
$trs                    = $transaction->type('sell')->status(['paid', 'shipping'])->with('user')->get();
$wait                   = $transaction->type('sell')->status('wait')->count();
$canceled               = $transaction->type('sell')->ondate([null , $expired->value])->status('wait')->with('user')->get();
$stocks                 = $td->critical((0 - $critical->value))->with(['varian', 'varian.product'])->get();
$totalproduct           = $product->get();
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
                                <th colspan="3">Transaksi yang harus ditangani</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trs as $data)
                            <tr>
                                <td class="text-left"><a href="{{route('backend.data.transaction.show', ['id' => $data['id'], 'type' => 'sell'])}}">{{$data['ref_number']}}</a></td>
                                <td>{{ $data['user']['name'] }}</td>
                                <td>
                                    @if($data['current_status']=='wait')
                                        <a href="{{route('backend.data.sell.getpaid', $data['id'])}}">Proses Selanjutnya</a>
                                    @elseif($data['current_status']=='paid')
                                        <a href="{{route('backend.data.shipment.edit', $data['shipment']['id'])}}">Proses Selanjutnya</a>
                                    @elseif($data['current_status']=='shipping')
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
                            <th colspan="3">Transaksi yang harus dibatalkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($canceled as $data)
                        <tr>
                            <td class="text-left"><a href="{{route('backend.data.transaction.show', ['id' => $data['id'], 'type' => 'sell'])}}">{{$data['ref_number']}}</a></td>
                            <td>{{ $data['user']['name'] }}</td>
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
    </div>
    
    <div class="row">
        @if($wait)
        <div class="col-sm-6">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th colspan="3">Nota bayar baru</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center" class="col-sm-12">
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
                                        <button type="submit" class="btn btn-md btn-primary" tabindex="2">Proses Selanjutnya</button>
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
                                <th colspan="3">Barang yang harus di restock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $data)
                            <tr>
                                <td class="text-left"><a href="{{route('backend.data.product.varian.show', ['pid' => $data['varian']['product']['id'], 'id' => $data['varian']['id']])}}">{{$data['varian']['sku']}}</a></td>
                                <td>{{ $data['varian']['product']['name'] }} {{ $data['varian']['size'] }}</td>
                                <td>
                                    <a href="{{route('backend.data.transaction.create', ['type' => 'buy'])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if(!$product->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Yang harus di lakukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$product->count())
                            <tr>
                                <td class="col-sm-6">Tambahkan Produk!</td>
                                <td class="col-sm-6">
                                    <a href="{{route('backend.data.product.create')}}">Proses Selanjutnya</a>
                                </td>
                            </tr>    
                            @endif   
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if(!$trs->count() && !$canceled->count() && !$wait && !$stocks->count() && $product->count())
            <div class="col-sm-12 text-center">
                <h3>There is nothing to do</h3>
                <h2>Keep your dashboard clean</h2>
            </div>
        @endif
    </div>
    <div class="row">
        @if($margins->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="4">Harga Produk yang perlu diubah (HPP VS HJ)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($margins as $data)
                            <tr>
                                <td class="col-sm-3">{{ $data['name'] }}</td>
                                <td class="col-sm-2">@money_indo($data['hpp']) </td>
                                <td class="col-sm-2">@money_indo($data['current_price']) </td>
                                <td class="col-sm-3">
                                    <a href="{{route('backend.data.product.price.index', $data['id'])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($negatives->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Saran Pemberian Bonus (Voucher/Campaign) (Batal belanja)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($negatives as $data)
                            <tr>
                                <td class="col-sm-6">{{ $data['name'] }}</td>
                                <td class="col-sm-6">
                                    <a href="{{route('backend.data.customer.show', $data['id'])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($positives->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Saran Pemberian Bonus (Voucher/Campaign) (Banyak belanja)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($positives as $data)
                            <tr>
                                <td class="col-sm-6">{{ $data['name'] }}</td>
                                <td class="col-sm-6">
                                    <a href="{{route('backend.data.customer.show', $data['id'])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($bought->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Yang harus di cek</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($bought->count())
                            <tr>
                                <td class="col-sm-6">Saatnya update etalase!</td>
                                <td class="col-sm-6">
                                    <a href="{{route('backend.settings.feature.index')}}">Proses Selanjutnya</a>
                                </td>
                            </tr>    
                            @endif   
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if(!$margins->count() && !$negatives->count() && !$positives->count() && !$bought->count() && !$trs->count() && !$canceled->count() && !$wait && !$stocks->count() && $product->count())
            <div class="col-sm-12 text-center">
                <h3>There is nothing to do</h3>
                <h2>Keep your dashboard clean</h2>
            </div>
        @endif
    </div>
@stop