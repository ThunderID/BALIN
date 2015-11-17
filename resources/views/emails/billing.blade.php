@extends('template.email.layout')

@section('content')
	<table class="row">
		<tr>
			<td class="wrapper last">
				<table class="twelve columns">
					<tr>
						<td>
							<h3>Billing Information</h3>
							<p>	<strong>{{$data['bill']['user']['name']}}, </strong></p>
							<p> Terima kasih telah memesan. </p>
							<p>
								Berikut tagihan pembayaran pemesanan.
							</p>
						</td>
						<td class="expander"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table  class="twelve columns">
		<thead>
			<tr>
				<th class="text-center">No.</th>
				<th class="text-center">Nama Produk</th>
				<th class="text-center">Qty</th>
				<th class="text-center">Harga</th>
				<th class="text-center">Diskon</th>
				<th class="text-center">Sub Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data['bill']['transactiondetails'] as $key => $detail)
				<tr>
					<td>{{($key+1)}}</td>
					<td>{{$detail['varian']['product']['name']}}{{$detail['varian']['size']}}</td>
					<td>{{$detail['quantity']}}</td>
					<td class="text-right">@money_indo($detail['price'])</td>
					<td class="text-right">@money_indo($detail['discount'])</td>
					<td class="text-right">@money_indo($detail['quantity'] * ($detail['price'] - $detail['discount']))</td>
				</tr>
			@endforeach
			<tr>
				<td colspan="5">Ongkos Kirim</td>
				<td class="text-right">@money_indo($data['bill']['shipping_cost'])</td>
			</tr>
			<tr>
				<td colspan="5">Diskon Referral</td>
				<td class="text-right">@money_indo(($data['bill']['voucher_discount'] ? $data['bill']['voucher_discount'] : 0))</td>
			</tr>
			<tr>
				<td colspan="5">Potongan Point</td>
				<td>@money_indo($data['bill']['discount_point'])</td>
			</tr>
			@if($data['bill']['amount']>0)
			<tr>
				<td colspan="5">Potongan Transfer</td>
				<td class="text-right">@money_indo($data['bill']['unique_number'])</td>
			</tr>
			@endif
			<tr>
				<td colspan="5">Grand Total</td>
				<td class="text-right">@money_indo($data['bill']['amount'])</td>
			</tr>										
		</tbody>
	</table>


	</br>

	<table class="row">
		<tr>
			<td class="wrapper last">
				<table class="twelve columns">
					<tr>
						<td>
							<h3>Shipping Information</h3>
							<p>	{!!$data['bill']['shipment']['address']['address']!!}</p>
							<p> <strong>{!!$data['bill']['shipment']['address']['address']!!}</strong> </p>
						</td>
						<td class="expander"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table class="row">
		<tr>
			<td class="wrapper last">
				<table class="twelve columns">
					<tr>
						<td>
							<p>Pembayaran dilakukan melalui transfer ke : </p>
							<p> {!!$data['balin']['bank_information']!!} </p>
						</td>
						<td class="expander"></td>
					</tr>
					<tr>
						<td>
							<p>Terima Kasih, </p>
							<p>PT. BALIN</p>
						</td>
						<td class="expander"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table class="row footer">
		<tr>
			<td class="wrapper">
				<table class="six columns">
					<tr>
						<td class="left-text-pad">
							<h5>Connect With Us:</h5>

							<table class="tiny-button facebook">
								<tr>
									<td>
										<a href="{{$data['balin']['facebook_url']}}">Facebook</a>
									</td>
								</tr>
							</table>
							<br>

							<table class="tiny-button twitter">
								<tr>
									<td>
										<a href="{{$data['balin']['twitter_url']}}">Twitter</a>
									</td>
								</tr>
							</table>
						</td>
						<td class="expander"></td>
					</tr>
				</table>
			</td>
			<td class="wrapper last">
				<table class="six columns">
					<tr>
						<td class="last right-text-pad">
							<h5>Contact Info:</h5>
							<p>Phone : {{$data['balin']['phone']}}</p>
							<p>Email : <strong>{{$data['balin']['email']}}</strong></p>
						</td>
						<td class="expander"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table class="row">
		<tr>
			<td class="wrapper last">
				<table class="twelve columns">
					<tr>
						<td align="center">
							<center>
								<p style="text-align:center;"><a href="{{route('balin.about.us')}}">About Us</a> | <a href="{{route('balin.term.condition')}}">Term & Condition</a></p>
							</center>
						</td>
						<td class="expander"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
@stop
