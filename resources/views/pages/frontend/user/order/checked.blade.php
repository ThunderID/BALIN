<div class="row">
	<div class="col-md-12 text-center">
		<p>Pesanan Anda telah kami terima dengan nomor pesanan <strong>#{{$transaction['ref_number']}}</strong></p>
		<p>Email tagihan akan dikirimkan ke alamat email Anda, harap melakukan pembayaran sebelum tanggal <strong>@datetime_indo($dateexpire)</strong></p>
		<p>&nbsp;</p>
		<p>Pembayaran dilakukan melalui transfer ke rekening : </p>
		<p> {!!$storeinfo['bank_information']!!} </p>
		<p>&nbsp;</p>
		<p><small><i>Anda dapat melihat pesanan anda di menu pribadi (Bagian Informasi Pengiriman & Tracking Order)</i></small></p>
	</div>
</div>