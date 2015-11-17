<?php 
	$status 	= ['abandoned' => 'Terabaikan', 'cart' => 'Keranjang', 'wait' => 'Proses, Menunggu Pembayaran', 'paid' => 'Sudah dibayar, belum dikirim', 'shipping' => 'Sedang dalam pengiriman', 'delivered' => 'Pesanan Complete', 'canceled' => 'Pesanan Dibatalkan'];
?>
@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-sm-9">
			<h3 class="page-title m-t-0">{{$title}}</h3>
		</div>
		<div class="col-sm-3">
			<p class="text-right m-t-lg"><a class="link-grey hover-black unstyle" href="{{route('frontend.profile.order.index')}}">Kembali</a></p>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
		<div class="row">
		<div class="col-md-6">
			<table>
				<tbody>
					<tr>
						<td><strong>{{$transaction['user']['name']}}</strong></td>
					</tr>
					<tr>
						<td>{{$transaction['user']['email']}}</td>
					</tr>
					<tr>
						<td>{{$transaction['user']['phone']}}</td>
					</tr>
					<tr>
						<td>{{$transaction['user']['address']}}, {{$transaction['user']['zipcode']}}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<table>
				<tbody>
					<tr class="row">
						<td class="col-sm-6"><strong>Invoice ID</strong></td>
						<td> {{$transaction['ref_number']}} </td>
					</tr>
					<tr class="row">
						<td class="col-sm-6"><strong>Invoice Date</strong></td>
						<td>@date_indo($transaction['transact_at'])</td>
					</tr>
					<tr class="row">
						<td class="col-sm-6"><strong>Status</strong></td>
						<td> 
							{{$status[$transaction['status']]}} 
							@if($transaction['status']=='wait')
								<small>
									<a class="link-grey hover-black unstyle" href="{{ route('frontend.profile.order.destroy', $transaction['ref_number']) }}">Batal</a>
								</small>
							@endif
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>No</th>
						<!-- <th>Item#</th> -->
						<th>Description</th>
						<th>Qty</th>
						<th>Unit Price</th>
						<th>Discount</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php $amount = 0;?>
					@forelse($transaction['transactiondetails'] as $key => $value)
						<?php $amount = $amount + (($value['price'] - $value['discount']) * $value['quantity']);?>
						<tr>
							<td>{!!($key+1)!!}</td>
							<!-- <td> {{$value['product']['sku']}} </td> -->
							<td> {{$value['product']['name']}} {{$value['varian']['size']}}</td>
							<td> {{$value['quantity']}} </td>
							<td> @money_indo($value['price']) </td>
							<td> @money_indo($value['discount']) </td>
							<td> @money_indo((($value['price'] - $value['discount']) * $value['quantity'])) </td>
						</tr>
					@empty
						<tr>
							<td colspan="6"> Tidak ada data </td>
						</tr>
					@endforelse
					@if($transaction['transactiondetails'])
						<?php 
							$discount_point = ($amount + $transaction['shipping_cost'] - $transaction['referral_discount'] - $transaction['unique_number']);
						?>
						<tr>
							<td colspan="3"></td>
							<td colspan="2"><strong>Ongkos Kirim</strong></td>
							<td>@money_indo($transaction['shipping_cost'])</td>
						</tr>
						<tr>
							<td colspan="3"></td>
							<td colspan="2"><strong>Diskon Referral</strong></td>
							<td>@money_indo($transaction['referral_discount'])</td>
						</tr>
						<tr>
							<td colspan="3"></td>
							<td colspan="2"><strong>Potongan Point</strong></td>
							<td>@money_indo($discount_point - ($transaction['amount']))</td>
						</tr>
						<tr>
							<td colspan="3"></td>
							<td colspan="2"><strong>Potongan Transfer</strong></td>
							<td>@money_indo($transaction['unique_number'])</td>
						</tr>
						<tr>
							<td colspan="3"></td>
							<td colspan="2"><strong>Total</strong></td>
							<td>@money_indo($transaction['amount'])</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

	<div class="row">
		<div class="col-md-4">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Alamat Pengiriman</th>
					</tr>
				</thead>
				<tbody>
					@if($transaction['shipment'])
						<tr>
							<td>a.n. {{$transaction['shipment']['receiver_name']}}</td>
						</tr>
						<tr>
							<td>{{$transaction['shipment']['address']['phone']}}</td>
						</tr>
						<tr>
							<td>{{$transaction['shipment']['address']['address']}}, {{$transaction['shipment']['address']['zipcode']}}</td>
						</tr>
					@else
						<tr>
							<td>Belum ada alamat pengiriman</td>
						</tr>
					@endif
				</tbody>
			</table>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Resi Pengiriman</th>
					</tr>
				</thead>
				<tbody>
					@if($transaction['shipment'] && !is_null($transaction['shipment']['receipt_number']))
						<tr>
							<td><strong>{{$transaction['shipment']['receipt_number']}}</strong></td>
						</tr>
					@else
						<tr>
							<td>Belum ada resi pengiriman</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="col-md-4">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th colspan="2">Nota Bayar</th>
					</tr>
				</thead>
				<tbody>
					@if($transaction['payment'])
						<tr>
							<td><strong>Tanggal</strong></td>
							<td>@date_indo($transaction['payment']['ondate'])</td>
						</tr>
						<tr>
							<td><strong>Nama Akun</strong></td>
							<td>{{$transaction['payment']['account_name']}}</td>
						</tr>
						<tr>
							<td><strong>Nomor Rekening</strong></td>
							<td>{{$transaction['payment']['account_number']}}</td>
						</tr>
						<tr>
							<td><strong>Total Bayar</strong></td>
							<td>@money_indo($transaction['payment']['amount'])</td>
						</tr>
					@else
						<tr>
							<td colspan="2">Belum ada nota bayar</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="col-md-4">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th colspan="2">Riwayat Pesanan</th>
					</tr>
				</thead>
				<tbody>
					@forelse($transaction['transactionlogs'] as $key => $value)
						<tr>
							<td> <strong> {{$status[$value['status']]}} </strong></td>
							<td> @datetime_indo($value['changed_at']) </td>
						</tr>
					@empty
						<tr>
							<td colspan="2"> Tidak ada riwayat pesanan </td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@stop