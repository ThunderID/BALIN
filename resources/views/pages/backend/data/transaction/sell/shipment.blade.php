<h2>Informasi Pengiriman</h2>
<div class="clearfix">&nbsp;</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="">Kurir</label>
			{!! Form::text('courier', null, [
					'class' => 'select-courier-by-name',
					'style' => 'width:100%'
			]) !!}
		</div>
	</div>
</div>
<h2>Alamat Customer</h2>
<div class="clearfix">&nbsp;</div>
<div class="row">
	<div class="col-md-5 p-xs m-l" style="background-color:#ddd">
		<div class="radio">
			<label>
				{!! Form::radio('address_choice', '0', null, null) !!} <h4>Alamat Tetap</h4>
			</label>
		</div>
		<div class="form-group">
			<label for="">Alamat</label>
			{!! Form::textarea('address', null, [
					'class' 		=> 'form-control',
					'rows'      => '2',
					'tabindex'  => '3',
					'style'     => 'resize:none;',
					'readonly'	=> 'readonly',
			]) !!}
		</div>
		<div class="form-group">
			<label for="">Kode Pos</label>
			{!! Form::input('number', 'postal_code', null, [
					'class' 		=> 'form-control',
					'readonly'	=> 'readonly',
			]) !!}
		</div>
		<div class="form-group">
			<label for="">No. Tlp</label>
			{!! Form::input('number', 'phone', null, [
					'class' 		=> 'form-control',
					'readonly'	=> 'readonly',
			]) !!}
		</div>
	</div>
	<div class="col-md-5 col-md-offset-1 p-xs " style="background-color:#ddd">
		<div class="radio">
			<label>
				{!! Form::radio('address_choice', '1', null, null) !!} <h4>Alamat Lain</h4>
			</label>
		</div>
		<div class="form-group">
			<label for="">Alamat</label>
			{!! Form::textarea('address', null, [
					'class' 		=> 'form-control',
					'rows'      => '2',
					'tabindex'  => '3',
					'style'     => 'resize:none;'
			]) !!}
		</div>
		<div class="form-group">
			<label for="">Kode Pos</label>
			{!! Form::input('number', 'postal_code', null, [
					'class' 		=> 'form-control',
			]) !!}
		</div>
		<div class="form-group">
			<label for="">No. Tlp</label>
			{!! Form::input('number', 'phone', null, [
					'class' 		=> 'form-control',
			]) !!}
		</div>
	</div>
</div>