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
				<h3>Validasi Pembayaran</h3>
			</td>
		</tr>
	</table>
	<hr/>
	<table class="row">
		<tr>
			<td class="wrapper last">
				<table class="twelve columns">
					<tr>
						<td>
							<br/>
							<p>	<strong>{{$data['paid']['user']['name']}}, </strong></p>
							<p> 
								Pembayaran untuk pesanan #{{$data['paid']['ref_number']}} telah kami terima pada tanggal @date_indo($data['paid']['payment']['ondate'])
							</p>
							<p>
								Atas nama {{$data['paid']['payment']['account_name']}} melalui rekening {{$data['paid']['payment']['destination']}}
							</p>
							<p>
								Pengiriman akan diproses selambat lambatnya 2 (dua) hari kerja setelah pembayaran di validasi.
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
