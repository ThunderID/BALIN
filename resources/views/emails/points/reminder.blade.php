@extends('template.email.layout')

@section('content')
	<table style="width:100%">
		<tr>
			<td width="10%"></td>
			<td width="80%">
				{{-- <img src="{{ $message->embed('Balin/web/image/balin-white.png') }}" style="max-width:150px; text-align:left;"> --}}
				<img src="{{ asset('Balin/web/image/balin-white.png') }}" style="max-width:150px; text-align:left;">
			</td>
			<td width="10%"></td>
		</tr>

		<tr>
			<td></br></br></td>
		</tr>

		<tr>
			<td width="10%"></td>
			<td width="80%">
				<p>Dear {{$data['points']['user']['name']}}, </p>
				<p>BALIN Point Anda sebesar @money_indo($data['points']['amount'])</p>
				<p>Akan expired pada tanggal {{$data['expired']}}</p>
				<p>Ayo Segera Gunakan Point Anda !</p>
			</td>
			<td width="10%"></td>
		</tr>

		<tr>
			<td></br></td>
		</tr>

		<tr>
			<td width="10%"></td>
			<td style="width:90%; text-align:center;">
				<a href="{{route('frontend.product.index')}}" class='btn'>LIHAT KATALOG BALIN</a>
			</td>
			<td width="10%"></td>
		</tr>

		<tr>
			<td><br></td>
		</tr>	

		<tr>
			<td width="10%"></td>
			<td width="80%">
				<p>
					Kind Regards, </br>
					Balin.id
				</p>
			</td>
			<td width="10%"></td>
		</tr>

	</table>
	</br>
	</br>
	</br>
@stop