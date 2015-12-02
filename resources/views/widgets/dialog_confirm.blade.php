{!! Form::open(['url' => '#', 'class' => 'form-horizontal dialog_confirm', 'data-coba' => 'yes']) !!}
	<div class="form-group">
		<div class="col-sm-12 text-center">
			<p>Apakah Anda Ingin Membatalkan Pesanan?</p>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12 text-center">
			<button type="submit" class="btn-hollow hollow-black-border">Iya</button>
			<button type="button" class="btn-hollow hollow-black-border" data-dismiss="modal">Tidak</button>
		</div>
	</div>
{!! Form::close() !!}