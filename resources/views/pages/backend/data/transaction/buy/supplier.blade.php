<h2>Pilih Supplier</h2>
<div class="clearfix">&nbsp;</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="supplier">Supplier <small><a href="{{route('backend.data.supplier.create')}}" target="blank">Baru</a></small></label>
			{!! Form::text('supplier', null, [
						'class' => 'select-supplier-by-name',
						'style'	=> 'width:100%'
			]) !!}
		</div>
	</div>
</div>