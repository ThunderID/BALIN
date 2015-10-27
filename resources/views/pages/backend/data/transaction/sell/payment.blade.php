<h2>Pilih Pembayaran</h2>
<div class="clearfix">&nbsp;</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="">Method</label>
			{!! Form::select('payment', ['bank_transfer' => 'Bank Transfer', 'point_log' => 'Point Log'], null, ['class' => 'form-control select-method-transaction']) !!}
		</div>
	</div>
</div>
<div class="row point" style="display:none;">
	<div class="col-md-12">
		<div class="form-group">
			<label for="">Jumlah Point</label>
			{!! Form::text('point', null, ['class' => 'form-control edit-point']) !!}
		</div>
	</div>
</div>