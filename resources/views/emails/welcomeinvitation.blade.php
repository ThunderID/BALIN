@extends('template.email.layout')

@section('content')
	<table style="width:100%">
		<tr>
			<td style="width:5%"></td>
			<td style="width:90%">
				<img src="<?php echo $message->embed('Balin/web/image/balin-white.png'); ?>" style="max-width:150px; text-align:left;">
			</td>
			<td style="width:5%"></td>
		</tr>

		<tr>
			<td></br></br></td>
		</tr>

		<tr>
			<td style="width:5%"></td>
			<td style="width:90%">
				<p>Welcome, {{$data['user']['name']}}</p>

				<p>
					Lorem ipsum Sint incididunt commodo irure enim esse elit commodo aliquip Duis esse elit et deserunt ut aute nostrud ut sit laborum cupidatat elit dolore consequat ut veniam laborum tempor aute culpa nulla sunt amet consectetur est pariatur esse Ut Ut qui veniam eu reprehenderit fugiat ea sed elit enim deserunt aliquip fugiat tempor aute Excepteur sint dolor incididunt labore voluptate cillum nostrud ullamco ad ex velit tempor mollit nisi et cupidatat Excepteur veniam labore Ut consectetur qui laboris tempor laboris reprehenderit aliquip proident esse pariatur pariatur dolor aliquip ofﬁcia nisi reprehenderit aute velit occaecat do cillum ullamco sunt cillum fugiat sit commodo Ut sed culpa veniam ex in non et ex ut laboris esse esse reprehenderit nostrud id nisi irure cillum et tempor sed consectetur sunt ut ut commodo enim aliqua adipisicing adipisicing amet esse quis et ad Ut nulla tempor ex qui anim esse et amet aute ea ut nostrud qui sunt consectetur ad Excepteur irure do est esse sunt Excepteur in ad non tempor ex dolor in et dolor ea nisi ullamco sit laborum anim pariatur mollit Ut cillum sit sint mollit eu Excepteur consectetur eiusmod Duis dolore mollit in reprehenderit culpa incididunt tempor Duis dolore id irure et dolore in quis mollit dolore Duis sed Excepteur nostrud eiusmod et id commodo sunt.
				</p>
			</td>
			<td style="width:5%"></td>
		</tr>

		<tr>
			<td></br></br></td>
		</tr>

		<tr>
			<td style="width:5%"></td>
			<td style="width:90%">
				<p>
					Kind Regards, </br>
					Balin.id
				</p>
			</td>
			<td style="width:5%"></td>
		</tr>

	</table>
	</br>
	</br>
	</br>
@stop