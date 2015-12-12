@extends('template.email.layout')

@section('content')
	<table style="width:100%">
		<tr class="row">
			<td class="col-sm-2" style="width:20%">
				<img src="{{ $message->embed('Balin/web/image/balin-white.png') }}" class="img img-responsive" style="max-width:200px">
			</td>
			<td class="col-sm-10" valign="top" style="text-align:right;width:40%">
				<h3>Customer Checkout</h3>
			</td>
		</tr>
	</table>
	<hr/>
	<br/>
	<table class="row">
		<tr>
			<td>
				<p>Customer telah melakukan checkout.</br>Detail Checkout adalah sebagai berikut:</p>
				</br>
				<p>Tanggal Checkout : @date_indo($data['date']) </p>
				<p>Nama Customer : {{ $data['name'] }}</p>
				<p>Nomor Resi : {{ $data['resi'] }}</p>
			</td>
		</tr>	
	</table>
	<br/>
	<br/>
	<br/>
	<br/>
@stop
