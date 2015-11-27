<?php 
	$status 	= ['abandoned' => 'Terabaikan', 'cart' => 'Keranjang', 'wait' => 'Checkout', 'paid' => 'Pembayaran Diterima', 'shipping' => 'Dalam Pengiriman', 'delivered' => 'Pesanan Complete', 'canceled' => 'Pesanan Dibatalkan'];
?>
		<div class="row">
		<div class="col-md-7 col-sm-7 col-xs-12">
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
					@if($transaction['user']['address']!='')
					<tr>
						<td>{{$transaction['user']['address']}}, {{$transaction['user']['zipcode']}}</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<div class="row clearfix">
				&nbsp;
			</div>
		</div>
		<div class="col-md-5 col-sm-5 col-xs-12">
			<table class="row">
				<tbody>
					<tr class="row">
						<td class="col-sm-6" valign="middle"><strong>Invoice ID</strong></td>
						<td valign="middle"> {{$transaction['ref_number']}} </td>
					</tr>
					<tr class="row">
						<td class="col-sm-6" valign="middle"><strong>Invoice Date</strong></td>
						<td valign="middle">@date_indo($transaction['transact_at'])</td>
					</tr>
					<tr class="row">
						<td class="col-sm-6" valign="middle"><strong>Status</strong></td>
						<td valign="middle"> 
							{{$status[$transaction['status']]}} 
							@if($transaction['status']=='wait')
								<small>
									<a class="link-grey hover-black unstyle" href="{{ route('frontend.user.order.destroy', $transaction['ref_number']) }}">Batal</a>
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
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th class="col-md-1 col-sm-1">No</th>
							<!-- <th>Item#</th> -->
							<th class="col-md-4 col-sm-4">Description</th>
							<th class="text-center col-md-1 col-sm-1">Qty</th>
							<th class="text-right col-md-2 col-sm-2">Unit Price</th>
							<th class="text-right col-md-2 col-sm-2">Discount</th>
							<th class="text-right col-md-2 col-sm-2">Total</th>
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
								<td class="text-center"> {{$value['quantity']}} </td>
								<td class="text-right"> @money_indo($value['price']) </td>
								<td class="text-right"> @money_indo($value['discount']) </td>
								<td class="text-right"> @money_indo((($value['price'] - $value['discount']) * $value['quantity'])) </td>
							</tr>
						@empty
							<tr>
								<td colspan="6"> Tidak ada data </td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>		
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 hidden-xs">
			<table class="table table-bordered table-hover table-striped">
				<tbody>
					@if($transaction['transactiondetails'])
						<?php 
							$discount_point = ($amount + $transaction['shipping_cost'] - $transaction['referral_discount'] - $transaction['unique_number']);
						?>
						<tr>
							<td class="text-right col-md-8 col-sm-8"><strong>Ongkos Kirim</strong></td>
							<td class="text-right">@money_indo($transaction['shipping_cost'])</td>
						</tr>
						<tr>
							<td class="text-right col-md-8 col-sm-8"><strong>Diskon Referral</strong></td>
							<td class="text-right">@money_indo($transaction['referral_discount'])</td>
						</tr>
						<tr>
							<td class="text-right col-md-8 col-sm-8"><strong>Potongan Point</strong></td>
							<td class="text-right">@money_indo($discount_point - ($transaction['amount']))</td>
						</tr>
						<tr>
							<td class="text-right col-md-8 col-sm-8"><strong>Potongan Transfer</strong></td>
							<td class="text-right">@money_indo($transaction['unique_number'])</td>
						</tr>
						<tr>
							<td class="text-right col-md-8 col-sm-8"><strong>Total</strong></td>
							<td class="text-right">@money_indo($transaction['amount'])</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<table class="table table-bordered table-hover table-striped">
				<tbody>
					@if($transaction['transactiondetails'])
						<?php 
							$discount_point = ($amount + $transaction['shipping_cost'] - $transaction['referral_discount'] - $transaction['unique_number']);
						?>
						<tr>
							<td class="text-right col-xs-12"><span class="pull-left"><strong>Ongkos Kirim</strong></span>@money_indo($transaction['shipping_cost'])</td>
						</tr>
						<tr>
							<td class="text-right col-xs-12"><span class="pull-left"><strong>Diskon Referral</strong></span>@money_indo($transaction['referral_discount'])</td>
						</tr>
						<tr>
							<td class="text-right col-xs-12"><span class="pull-left"><strong>Potongan Point</strong></span>@money_indo($discount_point - ($transaction['amount']))</td>
						</tr>
						<tr>
							<td class="text-right col-xs-12"><span class="pull-left"><strong>Potongan Transfer</strong></span>@money_indo($transaction['unique_number'])</td>
						</tr>
						<tr>
							<td class="text-right col-xs-12"><span class="pull-left"><strong>Total</strong></span>@money_indo($transaction['amount'])</td>
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
						@if(in_array($value['status'], ['wait', 'paid', 'ship', 'delivered', 'canceled']))
						<tr>
							<td> <strong> {{$status[$value['status']]}} </strong></td>
							<td> @datetime_indo($value['changed_at']) </td>
						</tr>
						@endif
					@empty
						<tr>
							<td colspan="2"> Tidak ada riwayat pesanan </td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>