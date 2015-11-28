<?php 
	$status 	= ['abandoned' => 'Terabaikan', 'cart' => 'Keranjang', 'wait' => 'Checkout', 'paid' => 'Pembayaran Diterima', 'shipping' => 'Dalam Pengiriman', 'delivered' => 'Pesanan Complete', 'canceled' => 'Pesanan Dibatalkan'];
?>
	<div class="row">
		<div class="col-md-8 col-sm-8 col-xs-12">
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
		<div class="col-md-4 col-sm-4 col-xs-12">
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
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<!-- normal tablet -->
		<div class="col-md-12 col-sm-12 hidden-xs chart-div">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-1 col-sm-1 hidden-xs">
						<p>No</p>
					</div>
					<div class="col-md-1 col-sm-2 hidden-xs">
						<p>Produk</p>
					</div>					
					<div class="col-md-10 col-sm-9 hidden-xs">
						<div class="row">
							<div class="col-sm-4 col-md-4"></div>
							<div class="col-sm-2 col-md-2">
								<p class="text-center">Kuantitas</p>
							</div>
							<div class="col-sm-2 col-md-2">
								<p class="text-right">Harga</p>
							</div>
							<div class="col-sm-2 col-md-2">
								<p class="text-right">Diskon</p>
							</div>
							<div class="col-md-2 col-sm-2">
								<p class="text-right">Total</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 chart-header">
			</div>
			<div class="row">
				<?php $amount = 0; $numItems = count($transaction['transactiondetails']); $i = 0; ?>
				@forelse($transaction['transactiondetails'] as $key => $value)
				<div class="col-md-12">
					<?php 
					$amount = $amount + (($value['price'] - $value['discount']) * $value['quantity']);
					?>
					<div class="col-md-12">
						<div class="row p-b-sm m-t-sm">
							<div class="col-md-1 col-sm-1"><p>{!!($key+1)!!}</p></div>

							<div class="col-md-1 col-sm-2 clearfix">
								<img class="img-responsive m-t-sm" src="{{ $value['product']['images'][0]['thumbnail'] }}" >
							</div>

							<div class="col-md-10 col-sm-9 ">
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<p class="m-b-xs">{{ $value['product']['name'] }}</p>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4 col-md-4">
										<p class="m-b-sm">Size :
											@if (strpos($value['varian']['size'], '.')==true)
											<?php $frac = explode('.', $value['varian']['size']); ?>
											{{ $frac[0].' &frac12;'}}
											@else
											{{ $value['varian']['size'] }}
											@endif
										</p>
									</div>
									<div class="col-sm-2 col-md-2 text-center">
										{{$value['quantity']}}
									</div>
									<div class="col-sm-2 col-md-2 text-right">
										@money_indo($value['price'])
									</div>
									<div class="col-sm-2 col-md-2 text-right">
										@money_indo($value['discount'])
									</div>
									<div class="col-sm-2 col-md-2 text-right">
										@money_indo((($value['price'] - $value['discount']) * $value['quantity']))
									</div>
								</div>							
							</div>
						</div>
						@if(++$i !== $numItems)
							<div class="col-md-12 clearfix border-bottom">&nbsp;</div>
						@endif
					</div>
				</div>
				@empty
				<div class="col-md-12 text-center">
					<p> Tidak ada data </p>
				</div>
				@endforelse						
			</div>
		</div>	

		<!-- mobile -->
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<div class="row chart-item" style="margin-top: -25px; padding-top:0px; border-top: 1px solid #ddd;">
				<?php $amount = 0;?>
				@forelse($transaction['transactiondetails'] as $key => $value)
				<div class="col-xs-10 col-xs-offset-1">
					<?php 
					$amount = $amount + (($value['price'] - $value['discount']) * $value['quantity']);
					?>

					@if($key != 0)
						<div class="row">
							<div class="col-xs-12 border-bottom"></div>
						</div>
					@endif

					<div class="clearfix">&nbsp;</div>

					<div class="row">
						<p class="text-left">{!!($key+1)!!}</p>
					</div>					
					<div class="row" style="margin-top: -35px;">
						<div class="col-xs-8 col-xs-offset-2">
							 <a href="#">
								<img class="img-responsive m-t-sm" src="{{ $value['product']['images'][0]['thumbnail'] }}" >
							 </a>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center">
							<h4 class="m-b-xs" style="font-size:20px; font-weight:300">{{ $value['product']['name'] }}</h4>
						</div>
					</div>
					<div class="row m-t-sm m-b-xs ">
						<div class="col-xs-12 text-center">
							<p>Size</p>
						</div>
						<div class="col-xs-12 text-center" style="margin-top:-10px;">
							<strong style="font-size: 16px;">
								@if (strpos($value['varian']['size'], '.')==true)
									<?php $frac = explode('.', $value['varian']['size']); ?>
									{{ $frac[0].' &frac12;'}}
								@else
									{{ $value['varian']['size'] }}
								@endif
							</strong>
						</div>
					</div>
					<div class="row m-t-sm m-b-none">
						<div class="col-xs-5 text-right" style="padding-left: 20px; padding-right: 0px; margin-right: 20px;">
							<p class="m-b-xs">Kuantitas</p>
						</div>
						<div class="col-xs-2 text-center" style="margin-left:-20px; padding-left:0px; margin-right:20px; padding-right:0px;">
							:
						</div>
						<div class="col-xs-5 text-left" style="margin-left:-20px; padding-left: 0px; padding-right:0px;">
							<p>
								<strong>
									{{$value['quantity']}}
								</strong>
							</p>
						</div>
					</div>
					<div class="row m-b-xs m-b-none">
						<div class="col-xs-5 text-right" style="padding-left: 20px; padding-right: 0px; margin-right: 20px;">
							<p class="m-b-xs">Harga</p>
						</div>
						<div class="col-xs-2 text-center" style="margin-left:-20px; padding-left:0px; margin-right:20px; padding-right:0px;">
							:
						</div>
						<div class="col-xs-5 text-left" style="margin-left:-20px; padding-left: 0px; padding-right:0px;">
							<p>
								<strong>
									@money_indo($value['price'])
								</strong>
							</p>
						</div>
					</div>
					<div class="row m-b-xs m-b-none">
						<div class="col-xs-5 text-right" style="padding-left: 20px; padding-right: 0px; margin-right: 20px;">
							<p class="m-b-xs">Discount</p>
						</div>
						<div class="col-xs-2 text-center" style="margin-left:-20px; padding-left:0px; margin-right:20px; padding-right:0px;">
							:
						</div>
						<div class="col-xs-5 text-left" style="margin-left:-20px; padding-left: 0px; padding-right:0px;">
							<p>
								<strong>
									@money_indo($value['discount'])
								</strong>
							</p>
						</div>
					</div>
					<div class="row m-b-xs m-b-none">
						<div class="col-xs-5 text-right" style="padding-left: 20px; padding-right: 0px; margin-right: 20px;">
							<p class="m-b-xs">Total</p>
						</div>
						<div class="col-xs-2 text-center" style="margin-left:-20px; padding-left:0px; margin-right:20px; padding-right:0px;">
							:
						</div>
						<div class="col-xs-5 text-left" style="margin-left:-20px; padding-left: 0px; padding-right:0px;">
							<p>
								<strong>
									@money_indo((($value['price'] - $value['discount']) * $value['quantity']))
								</strong>
							</p>
						</div>
					</div>					
				</div>
				@empty
				<div class="col-md-12 text-center">
					<p> Tidak ada data </p>
				</div>
				@endforelse						
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
			@if($transaction['shipment'] && !is_null($transaction['shipment']['receipt_number']))
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Resi Pengiriman</th>
					</tr>
				</thead>
				<tbody>
						<tr>
							<td><strong>{{$transaction['shipment']['receipt_number']}}</strong></td>
						</tr>
				</tbody>
			</table>
			@endif
		</div>
		<div class="col-md-4">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						@if($transaction['payment'])
							<th colspan="2">Nota Bayar</th>
						@else
							<th colspan="2">Lakukan Pembayaran Melalui</th>
					@endif
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
							<td colspan="2">{!!$storeinfo['bank_information']!!}</td>
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