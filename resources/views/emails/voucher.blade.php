@extends('template.email.layout')

@section('content')
	<table style="width:100%">
		<tr>
			<td width="10%"></td>
			<td width="80%">
				<img src="{{ $message->embed('Balin/web/image/balin-white.png') }}" style="max-width:150px; text-align:left; margin-bottom:40px;">
			</td>
			<td width="10%"></td>
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
							<h3>Dear Bpk/Ibu <strong>{{$data['user']['name']}},</strong></h3>
							{!!$data['content']!!}
						</td>
						<td class="expander"></td>
					</tr>
			</table>
			</td>
		</tr>
	</table>
	</br>
	</br>
	</br>
@stop