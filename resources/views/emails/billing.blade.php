@extends('template.email.layout')

@section('content')
<table style="width:100%">
	<tr class="row">
		<td class="col-sm-2" style="width:20%">
			<img src="Balin/web/image/logo-invoice.png" class="img img-responsive" style="max-width:200px">
		</td>
		<td class="col-sm-10" valign="top" style="text-align:right;width:40%">
			<h3>Invoice <strong>#{!!$data['bill']['ref_number']!!}</strong></h3>
		</td>
	</tr>
</table>
<hr/>
<br/>
<table style="width:100%">
	<tr class="row">
		<td class="col-sm-1" style="width:10%">&nbsp;</td>
		<td class="col-sm-2" style="width:3%">
			<div class="title-circle active">
				<div>1</div>
			</div>
		</td>
		<td class="col-sm-2" style="width:3%">
			<div class="title-circle">
				<div>2</div>
			</div>
		</td>
		<td class="col-sm-2" style="width:3%">
			<div class="title-circle">
				<div>3</div>
			</div>
		</td>
		<td class="col-sm-2" style="width:3%">
			<div class="title-circle">
				<div>4</div>
			</div>
		</td>
		<td class="col-sm-2" style="width:3%">
			<div class="title-circle">
				<div>5</div>
			</div>
		</td>
		<td class="col-sm-1" style="width:10%">&nbsp;</td>
	</tr>
</table>
<br><br>
<table style="width:100%;">
	<tr>
		<td class="col-sm-3">&nbsp;</td>
		<td class="col-sm-2" style="width:15%; height:50px;text-align:center;">
			<table style="border:2px solid;">
				<tr>
					<td style="background-color:white; border-radius:0px; color:black;border-bottom:none;padding:15px;">
						Tanggal Invoice
						<br/>
						<br/>
						@datetime_indo($data['bill']['transact_at'])
					</td>
				</tr>
			</table>
		</td>
		<td class="col-sm-2" style="width:15%; height:50px;text-align:center;">
			<table style="border:2px solid;" >
				<tr>
					<td style="background-color:black; border-radius:0px; color:white;border-bottom:none;padding:15px;">
						Jumlah Tagihan
						<br/>
						<br/>
						@money_indo($data['bill']['amount'])
					</td>
				</tr>
			</table>
		</td>
		<td class="col-sm-2" style="width:15%; height:50px;text-align:center;">
			<table style="border:2px solid;">
				<tr>
					<td style="background-color:white; border-radius:0px; color:black;border-bottom:none;padding:15px;">
						Batas Waktu
						<br/>
						<br/>
						@datetime_indo(new Carbon($data['bill']['transact_at'].' '.str_replace('-', '+' , $data['balin']['expired_paid'])))
					</td>
				</tr>
			</table>
		</td>
		<td class="col-sm-3">&nbsp;</td>
	</tr>
</table>
<br><br>
<table style="width:100%;">
	<tr>
		<td class="col-sm-12" style="width:100%; height:50px;text-align:left">
			<p>Dear {{$data['bill']['user']['name']}}, </p>
			<p>Terima kasih telah memesan. Pesanan Anda <span style="font-weight:bold">#{!!$data['bill']['ref_number']!!}</span> menunggu pembayaran. Silakan melakukan pembayaran ke rekening bank yang berada dibawah sebelum <span style="font-weight:bold">@datetime_indo(new Carbon($data['bill']['transact_at'].' '.str_replace('-', '+' , $data['balin']['expired_paid'])))</span> atau pesanan Anda akan dibatalkan. Berikut rincian tagihan pesanan Anda.</p>
		</td>
	</tr>
</table>
<br/>
<table style="width:100%">
	<thead>
		<tr>
			<th class="col-md-1 text-center" style="text-align:center;background-color:black;color:white;padding:10px;">No</th>
			<!-- <th>Item#</th> -->
			<th class="text-center col-md-4" style="text-align:center;background-color:black;color:white;padding:10px;">Item</th>
			<th class="text-center col-md-1" style="text-align:center;background-color:black;color:white;padding:10px;">Qty</th>
			<th class="text-right col-md-2" style="text-align:center;background-color:black;color:white;padding:10px;">Harga @</th>
			<th class="text-right col-md-2" style="text-align:center;background-color:black;color:white;padding:10px;">Diskon</th>
			<th class="text-right col-md-2" style="text-align:center;background-color:black;color:white;padding:10px;">Total</th>
		</tr>
	</thead>
	<tbody>
		<?php $amount = 0;?>
		@forelse($data['bill']['transactiondetails'] as $key => $value)
			<?php $amount = $amount + (($value['price'] - $value['discount']) * $value['quantity']);?>
			<tr>
				<td class="text-center" style="text-align:center;background-color:#C6C6C6;padding:5px;">{!!($key+1)!!}</td>
				<td style="text-align:left;background-color:#C6C6C6;padding:5px;"> {{$value['varian']['product']['name']}} {{$value['varian']['size']}}</td>
				<td class="text-center" style="text-align:center;background-color:#C6C6C6;padding:5px;"> {{$value['quantity']}} </td>
				<td class="text-right" style="text-align:right;background-color:#C6C6C6;padding:5px;"> @money_indo($value['price']) </td>
				<td class="text-right" style="text-align:right;background-color:#C6C6C6;padding:5px;"> @money_indo($value['discount']) </td>
				<td class="text-right" style="text-align:right;background-color:#C6C6C6;padding:5px;"> @money_indo((($value['price'] - $value['discount']) * $value['quantity'])) </td>
			</tr>
		@empty
			<tr>
				<td colspan="6"> Tidak ada data </td>
			</tr>
		@endforelse
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" style="border:none;"></td>
			<td>Ongkos Kirim</td>
			<td class="text-right" style="text-align:right;padding:3px;">@money_indo($data['bill']['shipping_cost'])</td>
		</tr>
		<tr>
			<td colspan="4" style="border:none;"></td>
			<td>Diskon Voucher</td>
			<td class="text-right" style="text-align:right;padding:3px;">@money_indo(($data['bill']['voucher_discount'] ? $data['bill']['voucher_discount'] : 0))</td>
		</tr>
		<tr>
			<td colspan="4" style="border:none;"></td>
			<td>Balin Point</td>
			<td class="text-right" style="text-align:right;padding:3px;">@money_indo($data['bill']['discount_point'])</td>
		</tr>
		<tr>
			<td colspan="4" style="border:none;"></td>
			<td>Potongan Transfer</td>
			<td class="text-right" style="text-align:right;padding:3px;">@money_indo($data['bill']['unique_number'])</td>
		</tr>
		<tr>
			<td colspan="4" style="border:none;"></td>
			<td>Total Bayar</td>
			<td class="text-right" style="text-align:right;padding:3px;">@money_indo($data['bill']['amount'])</td>
		</tr>
	</tbody>
</table>
<br/>
<br/>
<table style="width:100%">
	<tr class="col-sm-8">
		<td>
			<strong>Pembayaran dilakukan melalui </strong> {!!$data['balin']['bank_information']!!}
		</td>
		<td style="width:30%;text-align:right;">
			<small>
			<i><strong>Syarat dan Ketentuan </strong> : harap membayar selambat lambatnya {{str_replace('-', '', str_replace('day', '', str_replace('s', '', $data['balin']['expired_paid'])))}} hari setelah pemesanan </i>
			</small>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
			Jika anda ada kesulitan saat memesan silahkan menghubungi layanan pelanggan kami.
			<p>Email : {{$data['balin']['email']}}</p>
			<p>Telepon : {{$data['balin']['phone']}}</p>
		</td>
	</tr>
</table>
@stop
