@inject('product', 'App\Models\Product')
@inject('store', 'App\Models\StoreSetting')
@inject('trs', 'App\Models\Transaction')

<?php 

$margin                 = $store->ondate('now')->type('min_margin')->first();
$margins                = $product->margin($margin->value)->get();
$negatives              = $trs->frequentnegative([( !is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null ), 'now'])->get();
$positives              = $trs->frequentpositive([( !is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null ), 'now'])->get();
$bought                 = $trs->ondate([( !is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null ), 'now'])->type('buy')->status('delivered')->get();
?>
@extends('template.backend.layout') 

@section('content')
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

        @if(!$margins->count() && !$negatives->count() && !$positives->count() && !$bought->count())
            <div class="col-sm-12 text-center">
                <h3>There is nothing to do</h3>
                <h2>Keep your dashboard clean</h2>
            </div>
        @endif
    </div>
@stop