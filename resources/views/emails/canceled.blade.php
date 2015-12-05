@extends('template.email.layout')

@section('content')
	<table style="width:100%">
		<tr class="row">
			<td class="col-sm-2" style="width:20%">
				{!! HTML::image('Balin/web/image/balin-white.png', null, ['class' => 'img img-responsive', 'style' => 'max-width:200px;']) !!}
			</td>
			<td class="col-sm-3" style="width:40%">
				<h4>CV. BALIN INDONESIA</h4>
				<p>Phone {!!$data['balin']['phone']!!}</p>
				<p>Email {!!$data['balin']['email']!!}</p>
				<p>Website <a href="{!!$data['balin']['url']!!}">www.balin.id</a></p>
			</td>
			<td class="col-sm-7" valign="top" style="text-align:right;width:40%">
				<h3>Pembatalan Pesanan</h3>
			</td>
		</tr>
	</table>
	<hr/>
	<br/>
	<table class="row">
		<tr>
			<td class="wrapper last">
				<table class="twelve columns">
					<tr>
						<td>
							<p>Dear	<strong>{{$data['canceled']['user']['name']}}, </strong></p>
							<p> 
								Pesanan #{{$data['canceled']['ref_number']}} sudah dibatalkan karena belum diterima pembayaran dalam waktu 1x24 jam, atau Pesanan #{{$data['canceled']['ref_number']}} sudah dibatalkan karena permintaan customer.
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
	<br/>
	<br/>
	<br/>
	<br/>
@stop
