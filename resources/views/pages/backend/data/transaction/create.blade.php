
@extends('template.backend.layout') 
@section('content')
	<div class="row">
		<div class="col-md-12">
			{!! Form::open(['route' => 'backend.test.testcontroller.post', 'class' =>'wizard-big', 'id' => 'create-transaction']) !!}
				<h1>Customer</h1>
				<fieldset>
					<h2>Informasi Customer</h2>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Customer</label>
								{!! Form::text('product', null, [
											'class' => 'select-customer',
											'style'	=> 'width:100%'
								]) !!}
							</div>
						</div>
					</div>
				</fieldset>
				<h1>Produk</h1>
				<fieldset>
					<h2>Informasi Produk</h2>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Produk</label>
								{!! Form::text('product', null, [
											'class' 		=> 'select-product-by-name',
											'style'			=> 'width:100%',
											'data-price'	=> ''
								]) !!}
							</div>
						</div>
						<div class="col-md-1">
							<div class="form-group">
								<label>Qty</label>
								{!! Form::input('text', 'qty', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="harga">Harga</label>
								{!! Form::input('text', 'price', null, ['class' => 'form-control price']) !!}
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="diskon">Diskon</label>
								{!! Form::input('text', 'discount', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="harga">Jumlah Harga</label>
								{!! Form::input('text', 'price', null, ['class' => 'form-control']) !!}
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
				</fieldset>
				<h1>Pembayaran</h1>
				<fieldset>
					<h2>Informasi Pembayaran</h2>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Method</label>
								{!! Form::select('payment', ['bank_transfer' => 'Bank Transfer', 'point_log' => 'Point Log'], null, ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
				</fieldset>
				<h1>Pengiriman</h1>
				<fieldset>
					<h2>Informasi Pengiriman</h2>
					<div class="clearfix">&nbsp;</div>
				</fieldset>
				<h1>Transaksi Detail</h1>
				<fieldset>
					<h2>Informasi Transaksi Detail</h2>
					<div class="clearfix">&nbsp;</div>
				</fieldset>
			{!! Form::close() !!}
		</div>
	</div>
	{{-- 
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">	
					<label for="user_id">User ID</label>
					{!! Form::text('user_id', null, [
						'class'         => 'form-control', 
						'required'      => 'required', 
						'tabindex'      => '1', 
						'placeholder'   => ''
					]) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">	
					<label for="courier_id">Courier ID</label>
					{!! Form::text('courier_id', null, [
						'class'         => 'form-control', 
						'required'      => 'required', 
						'tabindex'      => '1', 
						'placeholder'   => ''
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">	
					<label for="referral_code">Refferal Code</label>
					{!! Form::text('referral_code', null, [
						'class'         => 'form-control', 
						'tabindex'      => '1', 
						'placeholder'   => ''
					]) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">	
					<label for="type">Type</label>
					{!! Form::text('type', null, [
						'class'         => 'form-control', 
						'required'      => 'required', 
						'tabindex'      => '1', 
						'placeholder'   => ''
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">	
					<label for="status">Status</label>
					{!! Form::text('status', null, [
						'class'         => 'form-control', 
						'required'      => 'required', 
						'tabindex'      => '1', 
						'placeholder'   => ''
					]) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">	
					<label for="shipping_cost">Shipping Cost</label>
					{!! Form::text('shipping_cost', null, [
						'class'         => 'form-control', 
						'required'      => 'required', 
						'tabindex'      => '1', 
						'placeholder'   => ''
					]) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">	
					<label>Produk</label>
					{!! Form::text('products[0][id]', null, [
						'class'         => 'form-control', 
						'required'      => 'required', 
						'tabindex'      => '1', 
						'placeholder'   => ''
					]) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">	
					<label>QTY</label>
					{!! Form::text('products[0][quantity]', null, [
						'class'         => 'form-control', 
						'required'      => 'required', 
						'tabindex'      => '1', 
						'placeholder'   => ''
					]) !!}
				</div>
			</div>
		</div>		 --}}
		{{-- <div class="row">
			<div class="col-md-12">
				<div class="clearfix">&nbsp;</div>
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.data.transaction.index') }}" class="btn btn-md btn-default" tabindex="6">Batal</a>
					<button type="submit" class="btn btn-md btn-success" tabindex="7">Simpan</button>
				</div>        
			</div>        
		</div> 		 --}}
	{{-- {!! Form::close() !!} --}}
@stop   

@section('script')
	var preload_data = [];
@stop

@section('script_plugin')
	@include('plugins.step')
	@include('plugins.select2')
	@include('plugins.microtemplate')
@stop
