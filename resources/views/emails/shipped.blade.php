@extends('template.email.layout')

@section('content')
	<table style="width:100%">
		<tr class="row">
			<td style="width:60%">
				<img src="{{ $message->embed('Balin/web/image/balin-white.png') }}" style="max-width:200px; text-align:left;">
			</td>
			<td valign="top" style="text-align:right;width:40%">
				<h3>Resi Pengiriman</h3>
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
			<td style="width:3%; text-align:center; padding: 5px; background-color: #ddd;">
				<div style="width:50px; margin: 0 auto;">
					<div>2</div>
					<p style="margin-bottom:0;">Paid</p>
				</div>
			</td>
			<td style="width:2%;">&nbsp;</td>
			<td style="width:3%; text-align:center; padding: 5px; background-color: #000; color: #fff;">
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
							<p>Dear	<strong>{{$data['ship']['user']['name']}}, </strong></p>
							<p> 
								Pesanan #{{$data['ship']['ref_number']}} sedang dalam proses pengiriman dengan nomor resi pengiriman
								<strong>{{$data['ship']['shipment']['receipt_number']}}</strong>, menggunakan jasa kurir {{$data['ship']['shipment']['courier']['name']}}
								ke alamat :
							</p>
							<p>
								{{$data['ship']['shipment']['address']['address']}}
							</p>
							<p>
								Silahkan gunakan nomor resi untuk track pengiriman.
							</p>
						</td>
						<td class="expander"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br/>
	<br/>
	<br/>
@stop
