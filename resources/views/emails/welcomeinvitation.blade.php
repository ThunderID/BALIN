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
				<!--  -->
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
							<h3>Selamat Datang, {{$data['user']['name']}}</h3>
							<p>
								Terima kasih telah mendaftar ke akun BALIN.
							</p>
							<p>
								Akun Anda sudah terdaftar dengan bonus promo referral sebesar @money_indo($data['user']['amount'])
							</p>
							<p>
								Login ke <a href="{{route('frontend.join.index')}}">akun Anda</a> untuk menikmati ratusan bonus belanja dari BALIN!
							</p>
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