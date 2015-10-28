<h2>Informasi Produk</h2>
<div class="clearfix">&nbsp;</div>
<!-- <div id="tmplt">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>Produk</label>
				<input type="text" name="product" class="select-product-by-name" style="width:100%" />
			</div>
		</div>
		<div class="col-md-1">
			<div class="form-group">
				<label>Qty</label>
				<input type="text" name="qty" class="form-control text-center transaction-input-qty" />
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="harga">Harga</label>
				<input type="text" name="price" class="form-control text-right transaction-input-price" @if(Input::get("type")!="buy") readonly @endif/>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="diskon">Diskon</label>
				<input type="text" name="discount" class="form-control text-right transaction-input-discount" @if(Input::get("type")!="buy") readonly @endif/>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="harga">Jumlah Harga</label>
				<input type="text" name="tot_price" class="form-control text-right transaction-input-jum-price" />
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
</div> -->
<div id="template"></div>
<div class="row">
	<div class="col-md-2 col-md-offset-9">
		<div class="form-group">
			<label for="harga">Total Harga</label>
			{!! Form::text('price', null, ['class' => 'form-control text-right', 'id' => 'total_price']) !!}
		</div>
	</div>
</div>