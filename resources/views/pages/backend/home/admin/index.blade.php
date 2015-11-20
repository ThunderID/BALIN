@inject('audit', 'App\Models\Auditor')
@inject('trs', 'App\Models\Transaction')

<?php 
// $cancels            = $trs->auditingcanceled([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->with('user')->get();
$carts              = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('abandoned_cart')->with(['user'])->get();
$cancels            = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('transaction_canceled')->staff(true)->with(['user'])->get();
$paids              = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('transaction_paid')->with(['user'])->get();
$ship               = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('transaction_shipping')->with(['user'])->get();
$deliver            = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('transaction_delivered')->with(['user'])->get();
$voucher            = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('voucher_added')->vouchertype(['free_Shipping_cost', 'debit_point'])->with(['user'])->get();
$point              = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('point_added')->with(['user'])->get();
$quota              = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('quota_added')->with(['user'])->get();
$prices             = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('price_changed')->with(['user'])->get();
$policies           = $audit->ondate([(!is_null(Auth::user()->last_logged_at) ? Auth::user()->last_logged_at->format('Y-m-d H:i:s') : null), ' + 7 hours '])->type('policy_changed')->with(['user'])->get();
?>

@extends('template.backend.layout') 

@section('content')
    <div class="row">
        @if($carts->count())
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Abandoned cart</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $data)
                            <tr>
                                <td class="text-left col-sm-10">@if($data['user']) {{$data['user']['name']}} @else System @endif meninggalkan keranjang </td>
                                <td class="col-sm-2">
                                    <a href="{{route('backend.data.transaction.show', [$data['table_id'], 'type' => 'sell'])}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($cancels->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Pembatalan Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cancels as $data)
                            <tr>
                                <td class="col-sm-8 text-left">@if($data['user']) {{$data['user']['name']}} @else System @endif melakukan {{$data['event']}} </td>
                                <td class="col-sm-4">
                                    <a href="{{route('backend.data.transaction.show', [$data['table_id'], 'type' => 'sell'])}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($paids->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Penanganan Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paids as $data)
                            <tr>
                                <td class="col-sm-8 text-left">@if($data['user']) {{$data['user']['name']}} @else System @endif melakukan {{$data['event']}} </td>
                                <td class="col-sm-4">
                                    <a href="{{route('backend.data.transaction.show', [$data['table_id'], 'type' => 'sell'])}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

         @if($ship->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Penanganan Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ship as $data)
                            <tr>
                                <td class="col-sm-8 text-left">@if($data['user']) {{$data['user']['name']}} @else System @endif melakukan {{$data['event']}} </td>
                                <td class="col-sm-4">
                                    <a href="{{route('backend.data.transaction.show', [$data['table_id'], 'type' => 'sell'])}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

         @if($deliver->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Penanganan Transaksi Lengkap</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deliver as $data)
                            <tr>
                                <td class="col-sm-8 text-left">@if($data['user']) {{$data['user']['name']}} @else System @endif melakukan {{$data['event']}} </td>
                                <td class="col-sm-4">
                                    <a href="{{route('backend.data.transaction.show', [$data['table_id'], 'type' => 'sell'])}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($voucher->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Penambahan Voucher Manual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($voucher as $data)
                            <tr>
                                <td class="col-sm-8 text-left">@if($data['user']) {{$data['user']['name']}} @else System @endif melakukan {{$data['event']}} </td>
                                <td class="col-sm-4">
                                    <a href="{{route('backend.settings.voucher.show', [$data['table_id']])}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($point->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Penambahan Point Manual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($point as $data)
                            <tr>
                                <td class="col-sm-8 text-left">@if($data['user']) {{$data['user']['name']}} @else System @endif melakukan {{$data['event']}} </td>
                                <td class="col-sm-4">
                                    <a href="{{route('backend.data.customer.show', [$data['table_id']])}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($quota->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Penambahan Quota Manual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quota as $data)
                            <tr>
                                <td class="col-sm-8 text-left">@if($data['user']) {{$data['user']['name']}} @else System @endif melakukan {{$data['event']}} </td>
                                <td class="col-sm-4">
                                    <a href="{{route('backend.settings.voucher.show', [$data['table_id']])}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($prices->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Perubahan Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prices as $data)
                            <tr>
                                <td class="col-sm-8 text-left">@if($data['user']) {{$data['user']['name']}} @else System @endif melakukan {{$data['event']}} </td>
                                <td class="col-sm-4">
                                    <a href="{{route('backend.data.product.show', [$data['table_id']])}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($policies->count())
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Perubahan Policy</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($policies as $data)
                            <tr>
                                <td class="col-sm-10 text-left">@if($data['user']) {{$data['user']['name']}} @else System @endif melakukan {{$data['event']}} </td>
                                <td class="col-sm-2">
                                    <a href="{{route('backend.settings.policies.index')}}">Lihat</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if(!$cancels->count() && !$carts->count() && !$paids->count() && !$ship->count() && !$deliver->count() && !$voucher->count() && !$point->count() && !$quota->count() && !$prices->count() && !$policies->count())
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