@extends('template.email.layout')

@section('content')
	<table class="row">
		<tr>
			<td class="wrapper last">
				<table class="twelve columns">
					<tr>
						<td>
							<h3>Pembatalan</h3>
							<p>	<strong>{{$data['canceled']['user']['name']}}, </strong></p>
							<p> 
								Pesanan #{{$data['canceled']['ref_number']}} sudah dibatalkan.
							</p>
							<p>
								Nikmati bonus belanja dari produk BALIN lainnya.
							</p>
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
