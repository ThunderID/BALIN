@inject('transaction', 'App\Models\Transaction')
@inject('store', 'App\Models\StoreSetting')
@inject('td', 'App\Models\TransactionDetail')
@inject('product', 'App\Models\Product')
@inject('courier', 'App\Models\Courier')

<?php 
$expired                = $store->ondate('now')->type('expired_paid')->first();
$critical               = $store->ondate('now')->type('critical_stock')->first();
$trs                    = $transaction->type('sell')->status(['paid', 'packed', 'shipping'])->with('user')->get();
$wait                   = $transaction->type('sell')->status('wait')->count();
$canceled               = $transaction->type('sell')->ondate([null , $expired->value])->status('wait')->with('user')->get();
$stocks                 = $td->critical((0 - $critical->value))->with(['varian', 'varian.product'])->get();
$totalproduct           = $product->get();
$totalcourier           = $courier->wherehas('shippingcosts', function($q){$q;})->get();
?>

@extends('template.backend.layout') 

@section('content')
    <div class="row">
        @include('pages.backend.home.staff')

        @if(!$trs->count() && !$canceled->count() && !$wait && !$stocks->count() && $product->count() && $totalcourier->count())
            <div class="col-sm-12 text-center">
                <h3>There is nothing to do</h3>
                <h2>Keep your dashboard clean</h2>
            </div>
        @endif
    </div>
@stop

@section('script')
    var preload_data = [];
    var preload_data_tag = [];
@stop

@section('script_plugin')
    @include('plugins.select2')
@stop