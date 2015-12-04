@inject('product', 'App\Models\Product')
@inject('transaction', 'App\Models\Transaction')
@inject('payment', 'App\Models\Payment')
@inject('point', 'App\Models\PointLog')

<?php 
// $total_product          = $product->HasStocks(true)->count();
$total_product          = 0;
$total_trans            = $payment->transactiontype('sell')->transactionstatus(['paid', 'packed', 'shipping', 'delivered'])->transactionondate(['first day of this month', 'last day of this month'])->sum('amount');
$freq_trans             = $transaction->type('sell')->status(['paid', 'packed', 'shipping', 'delivered'])->ondate(['first day of this month', 'last day of this month'])->count();
$total_point            = $point->ondate(['first day of this month', 'last day of this month'])->debit(true)->sum('amount');
$total_product          = $product->count();
$waitingtrs             = $transaction->type('sell')->ondate(['first day of this week', '+ 7 hours'])->status('wait')->get();
$paidtrs                = $transaction->type('sell')->ondate(['first day of this week', '+ 7 hours'])->status('paid')->get();
$shippedtrs             = $transaction->type('sell')->ondate(['first day of this week', '+ 7 hours'])->status('shipping')->get();
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default panel-widget">
                <div class="panel-body">
                    {{$total_product}}
                </div>
                <div class="panel-heading">Total Produk<a href="{{route('backend.data.product.index')}}" class="pull-right">&nbsp; <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default panel-widget">
                <div class="panel-body">
                    @money_indo($total_point)
                </div>
                <div class="panel-heading">Total Poin (Bulan Ini)<a href="{{route('backend.report.finance.point')}}" class="pull-right">&nbsp; <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default panel-widget">
                <div class="panel-body">
                    {{$freq_trans}}
                </div>
                <div class="panel-heading">Total Jual (Bulan Ini)<a href="{{route('backend.data.product.index')}}" class="pull-right">&nbsp; <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default panel-widget">
                <div class="panel-body">
                    @money_indo($total_trans)
                </div>
                <div class="panel-heading">Jumlah Jual (Bulan Ini)<a href="{{route('backend.data.product.index')}}" class="pull-right">&nbsp; <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="col-sm-3 text-left">#Waiting</th>
                            <th class="">Kostumer</th>
                            <th class=" text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($waitingtrs) == 0)
                            <tr>
                                <td colspan="6" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @else                                                                 
                            @foreach ($waitingtrs as $data)
                            <tr>
                                <td class="text-left"><a href="{{route('backend.data.transaction.show', ['id' => $data['transaction_id'], 'type' => 'sell'])}}">{{$data['ref_number']}}</a></td>
                                <td>{{ $data['user']['name'] }}</td>
                                <td class="text-center">@money_indo($data['amount']) </td>
                            </tr>       
                            @endforeach 
                        @endif
                    </tbody>
                </table> 
            </div>                 
        </div>
        <div class="col-sm-4 col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="col-sm-3 text-left">#Paid</th>
                            <th class="">Kostumer</th>
                            <th class=" text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($paidtrs) == 0)
                            <tr>
                                <td colspan="6" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @else                                                                 
                            @foreach ($paidtrs as $data)
                            <tr>
                                <td class="text-left"><a href="{{route('backend.data.transaction.show', ['id' => $data['transaction_id'], 'type' => 'sell'])}}">{{$data['ref_number']}}</a></td>
                                <td>{{ $data['user']['name'] }}</td>
                                <td class="text-center">@money_indo($data['amount']) </td>
                            </tr>       
                            @endforeach 
                        @endif
                    </tbody>
                </table> 
            </div>                 
        </div>
        <div class="col-sm-4 col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="col-sm-3 text-left">#Shipped</th>
                            <th class="">Kostumer</th>
                            <th class=" text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($shippedtrs) == 0)
                            <tr>
                                <td colspan="6" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @else                                                                 
                            @foreach ($shippedtrs as $data)
                            <tr>
                                <td class="text-left"><a href="{{route('backend.data.transaction.show', ['id' => $data['transaction_id'], 'type' => 'sell'])}}">{{$data['ref_number']}}</a></td>
                                <td>{{ $data['user']['name'] }}</td>
                                <td class="text-center">@money_indo($data['amount']) </td>
                            </tr>       
                            @endforeach 
                        @endif
                    </tbody>
                </table> 
            </div>                 
        </div>
    </div>
@stop