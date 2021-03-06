<?php
    $status     = ['abandoned' => 'Terabaikan', 'cart' => 'Keranjang', 'wait' => 'Checkout', 'paid' => 'Pembayaran Diterima', 'packed' => 'Packing', 'shipping' => 'Dalam Pengiriman', 'delivered' => 'Pesanan Complete', 'canceled' => 'Pesanan Dibatalkan'];
?>
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
                                <td class="text-left"><a href="{{route('backend.data.transaction.show', ['id' => $data['id'], 'type' => 'sell'])}}">{{$data['ref_number']}}</a></td>
                                <td>{{ $data['user']['name'] }}</td>
                                <td><strong>{{ $status[$data['current_status']] }}</strong></td>
                                <td>
                                    @if($data['current_status']=='wait')
                                        <a href="{{route('backend.data.sell.getpaid', $data['id'])}}">Proses Selanjutnya</a>
                                    @elseif($data['current_status']=='paid' || $data['current_status']=='packed')
                                        <a href="{{route('backend.data.shipment.edit', $data['shipment']['id'])}}">Proses Selanjutnya</a>
                                    @elseif($data['current_status']=='shipping')
                                        {!! Form::open(['url' => route('backend.data.transaction.status', [$data['id']]), 'method' => 'GET']) !!}
                                        <div class="form-group">
                                            {!!Form::hidden('status', 'delivered')!!}
                                            {!! Form::text('notes', null, [
                                                        'class'         => 'form-control',
                                                        'placeholder'   => 'Diterima Oleh : xxx',
                                            ]) !!}
                                        </div>
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-md btn-primary" tabindex="2">Proses Selanjutnya</button>
                                        </div>
                                    {!!Form::close()!!}
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

        @if(!$product->count() || !$totalcourier->count())
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
                            @if(!$totalcourier->count())
                            <tr>
                                <td class="col-sm-6">Tambahkan Kurir / Ongkos Kirim!</td>
                                <td class="col-sm-6">
                                    <a href="{{route('backend.settings.courier.index')}}">Proses Selanjutnya</a>
                                </td>
                            </tr>    
                            @endif   
                        </tbody>
                    </table> 
                </div>
            </div>
        @endif