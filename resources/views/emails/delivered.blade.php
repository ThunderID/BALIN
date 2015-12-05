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
				<h3>Pesanan Sudah Lengkap</h3>
			</td>
		</tr>
	</table>
	<hr/>
	<br/>
	<table style="width:100%">
		<tr class="row">
			<td class="col-sm-1" style="width:10%">&nbsp;</td>
			<td class="col-sm-2" style="width:3%">
				<div class="title-circle active">
					<div>1</div>
				</div>
			</td>
			<td class="col-sm-2" style="width:3%">
				<div class="title-circle">
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
							<p>	Dear <strong>{{$data['delivered']['user']['name']}}, </strong></p>
							<p> 
								Menurut pantauan kami pesanan dengan nomor invoice #{{$data['delivered']['ref_number']}} dengan nomor resi #{{$data['delivered']['shipment']['receipt_number']}} sudah sampai dialamat penerima dan {{$data['notes']}}.
							</p>
							<p>
								Terima kasih untuk kepercayaan anda. 
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
@stop
