@extends('template.email.layout')

@section('content')
	<table style="width:100%">
		<tr class="row">
			<td class="col-sm-2" style="width:20%">
				<img src="{{ $message->embed('Balin/web/image/logo-invoice.png') }}" class="img img-responsive" style="max-width:200px">
			</td>
			<td class="col-sm-10" valign="top" style="text-align:right;width:40%">
				<h3>Validasi Pembayaran</h3>
			</td>
		</tr>
	</table>
	<hr/>
	<br/>
	<table style="width:100%">
		<tr class="row">
			<td style="width:10%">&nbsp;</td>
			<td style="width:3%; text-align:center; padding: 5px; background-color: #ddd;">
				<div style="width:50px; margin: 0 auto;">
					<div>1</div>
					<p style="margin-bottom:0;">Checkout</p>
				</div>
			</td>
			<td style="width:2%;">&nbsp;</td>
			<td style="width:3%; text-align:center; padding: 5px; background-color: #000; color: #fff;">
				<div style="width:50px; margin: 0 auto;">
					<div>2</div>
					<p style="margin-bottom:0;">Paid</p>
				</div>
			</td>
			<td style="width:2%;">&nbsp;</td>
			<td style="width:3%; text-align:center; padding: 5px; background-color: #ddd;">
				<div style="width:50px; margin: 0 auto;">
					<div>3</div>
					<p style="margin-bottom:0;">Shipped</p>
				</div>
			</td>
			<td style="width:2%;">&nbsp;</td>
			<td style="width:3%; text-align:center; padding: 5px; background-color: #ddd;">
				<div style="width:50px; margin: 0 auto;">
					<div>4</div>
					<p style="margin-bottom:0;">Deliverd</p>
				</div>
			</td>
			<td class="col-sm-1" style="width:10%">&nbsp;</td>
		</tr>
	</table>
	<br><br>
	<table class="row">
		<tr>
			<td class="wrapper last">
				<table class="twelve columns">
					<tr>
						<td>
							<br/>
							<?php
								$point 			= 0;
								foreach ($data['paid']['pointlogs'] as $key => $value) 
								{
									$point 		= $point + $value['amount'];
								}
							?>
							<p>Dear <strong>{{$data['paid']['user']['name']}}, </strong></p>
							<p> 
								Pembayaran untuk pesanan #{{$data['paid']['ref_number']}} telah kami terima pada tanggal 
								@if($data['paid']['payment']) 
									@date_indo($data['paid']['payment']['ondate']) 
								@else 
									@date_indo($data['paid']['updated_at']) 
								@endif
							</p>
							@if($data['paid']['payment'])
								<p>
									Atas nama {{$data['paid']['payment']['account_name']}} melalui rekening {{$data['paid']['payment']['destination']}}
								</p>
							@else
								<p>
									Menggunakan point BALIN sebesar @money_indo(abs($point))
								</p>
							@endif
							<p>
								Pengiriman akan diproses selambat lambatnya 2 (dua) hari kerja setelah pembayaran di validasi.
							</p>
						</td>
						<td class="expander"></td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>
							Jika anda ada kesulitan saat memesan silahkan menghubungi layanan pelanggan kami.
							<p>Email : {{$data['balin']['email']}}</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br/>
	<br/>
	<br/>
	<br/>
@stop
