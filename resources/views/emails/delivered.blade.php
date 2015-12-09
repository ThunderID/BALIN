@extends('template.email.layout')

@section('content')
	<table style="width:100%">
		<tr class="row">
			<td style="width:60%">
				<img src="{{ $message->embed('Balin/web/image/balin-white.png') }}" style="max-width:200px; text-align:left;">
			</td>
			<td valign="top" style="text-align:right;width:40%">
				<h3>Pesanan Anda Sudah Tiba Di Tujuan</h3>
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
			<td style="width:3%; text-align:center; padding: 5px; background-color: #ddd;">
				<div style="width:50px; margin: 0 auto;">
					<div>3</div>
					<p style="margin-bottom:0;">Shipped</p>
				</div>
			</td>
			<td style="width:2%;">&nbsp;</td>
			<td style="width:3%; text-align:center; padding: 5px; background-color: #000; color: #fff;">
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
							<p>	Dear <strong>{{$data['delivered']['user']['name']}}, </strong></p>
							<p> 
								Menurut pantauan kami pesanan dengan nomor invoice #{{$data['delivered']['ref_number']}} dengan nomor resi #{{$data['delivered']['shipment']['receipt_number']}} sudah sampai dialamat penerima dan {{$data['notes']}}.
							</p>
							<p>
								Terima kasih untuk kepercayaan anda. 
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
