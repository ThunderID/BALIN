@extends('template.email.layout')

@section('content')
	<table style="width:100%">
		<tr class="row">
			<td class="col-sm-2" style="width:20%">
				<img src="Balin/web/image/logo-invoice.png" class="img img-responsive" style="max-width:200px">
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
			<td class="col-sm-1" style="width:10%">&nbsp;</td>
			<td class="col-sm-2" style="width:3%">
				<div class="title-circle">
					<div>1</div>
				</div>
			</td>
			<td class="col-sm-2" style="width:3%">
				<div class="title-circle active">
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
	<table class="row">
		<tr>
			<td class="wrapper last">
				<table class="twelve columns">
					<tr>
						<td>
							<br/>
							<p>Dear <strong>{{$data['paid']['user']['name']}}, </strong></p>
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
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>Jika anda ada kesulitan saat memesan silahkan menghubungi Customer Care kami.</td>
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
