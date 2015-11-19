@inject('audit', 'App\Models\Auditor')
@inject('trs', 'App\Models\Transaction')

<?php 
// $cancels            = $trs->auditingcanceled([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->with('user')->get();
$cancels            = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('transaction_canceled')->with('user')->get();
$carts              = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('abandoned_cart')->with('user')->get();
$paids              = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('transaction_paid')->with('user')->get();
$ship               = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('transaction_shipping')->with('user')->get();
$deliver            = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('transaction_delivered')->with('user')->get();
$voucher            = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('voucher_added')->with('user')->get();
$point              = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('point_added')->with('user')->get();
$quota              = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('quota_added')->with('user')->get();
$prices             = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('price_changed')->with('user')->get();
$policies           = $audit->ondate([Auth::user()->last_logged_at->format('Y-m-d H:i:s'), 'now'])->type('policy_changed')->with('user')->get();
?>

@extends('template.backend.layout') 

@section('content')
    <div class="row">
        @if($cancels->count())
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Transaksi yang dibatalkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cancels as $data)
                            <tr>
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.data.transaction.show', [$data['id'], 'type' => $data['type']])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($carts->count())
            <div class="col-sm-6">
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
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.data.transaction.show', [$data['id'], 'type' => $data['type']])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($paids->count())
            <div class="col-sm-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Transaksi yang dibatalkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paids as $data)
                            <tr>
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.data.transaction.show', [$data['id'], 'type' => $data['type']])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

         @if($ship->count())
            <div class="col-sm-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Transaksi yang dibatalkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ship as $data)
                            <tr>
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.data.transaction.show', [$data['id'], 'type' => $data['type']])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

         @if($deliver->count())
            <div class="col-sm-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Transaksi yang dibatalkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deliver as $data)
                            <tr>
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.data.transaction.show', [$data['id'], 'type' => $data['type']])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($voucher->count())
            <div class="col-sm-4">
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
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.settings.voucher.show', [$data['table_id']])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($point->count())
            <div class="col-sm-4">
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
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.data.customers.show', [$data['table_id']])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($quota->count())
            <div class="col-sm-4">
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
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.data.customers.show', [$data['table_id']])}}">Proses Selanjutnya</a>
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
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.data.product.show', [$data['table_id']])}}">Proses Selanjutnya</a>
                                </td>
                            </tr>       
                            @endforeach 
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif

        @if($policies->count())
            <div class="col-sm-6">
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
                                <td class="text-center">{{$data['user']['name']}} melakukan {{$data['event']}} </td>
                                <td>
                                    <a href="{{route('backend.settings.policies.index')}}">Proses Selanjutnya</a>
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