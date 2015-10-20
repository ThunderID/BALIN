@extends('template.backend.layout') 


@section('content')
	{!! Form::open(array('route' => 'backend.test.testcontroller.post')) !!}
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">	
					<label for="user">User ID</label>
					{!! Form::text('user', null, [
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
					<label for="refferal_code">Refferal Code</label>
					{!! Form::text('refferal_code', null, [
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
		</div>		
		<div class="row">
			<div class="col-md-12">
				<div class="clearfix">&nbsp;</div>
				<div class="form-group text-right">
					<!-- <a href="{{ URL::route('backend.data.product.index') }}" class="btn btn-md btn-default" tabindex="6">Batal</a> -->
					<button type="submit" class="btn btn-md btn-success" tabindex="7">Simpan</button>
				</div>        
			</div>        
		</div> 		
	{!! Form::close() !!}
@stop   