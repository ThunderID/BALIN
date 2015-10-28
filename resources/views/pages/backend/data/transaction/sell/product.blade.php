<h2>Pilih Produk</h2>
<div class="clearfix">&nbsp;</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Produk</label>
			{!! Form::text('product[]', null, [
						'class' 		=> 'select-product-by-name',
						'style'			=> 'width:100%',
						'data-price'	=> ''
			]) !!}
		</div>
	</div>
	<div class="col-md-1">
		<div class="form-group">
			<label>Qty</label>
			{!! Form::input('text', 'qty[]', null, ['class' => 'form-control text-center transaction-input-qty']) !!}
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label for="harga">Harga</label>
			{!! Form::input('text', 'price[]', null, ['class' => 'form-control text-right transaction-input-price', 'readonly' => 'readonly']) !!}
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label for="diskon">Diskon</label>
			{!! Form::input('text', 'discount[]', null, ['class' => 'form-control text-right transaction-input-discount', 'readonly' => 'readonly']) !!}
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label for="harga">Jumlah Harga</label>
			{!! Form::input('text', 'tot_price[]', null, ['class' => 'form-control text-right transaction-input-jum-price', "data-inputmask" => "'alias' : 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'prefix': 'Rp', 'placeholder': '0'"]) !!}
		</div>
	</div>
	<div class="col-md-1">
		<div class="form-group">
			<a href="javascript:;" class="btn btn-sm btn-default m-t-mds btn-add">
				<i class="fa fa-plus"></i>
			</a>
		</div>
	</div>
</div>
<div id="template"></div>
<div class="row">
	<div class="col-md-2 col-md-offset-9">
		<div class="form-group">
			<label for="harga">Total Harga</label>
			{!! Form::input('number', 'price', null, ['class' => 'form-control', 'id' => 'total-price']) !!}
		</div>
	</div>
</div>