<?php 	
	$carts = Cookie::get('baskets'); 
?>
@extends('template.frontend.layout')

@section('content')
	<div class="container mt-75">
		<div class="row">
			<div class="col-lg-12">
				@include('widgets.pageelements.pagetitle', array('pagetitle' => 'Checkout'))
				<div class="clearfix">&nbsp;</div>
				@include('widgets.alerts')
			</div>
		</div>
		<div class="row">
			<div class="col-sm-7">
				<div class="row chart-header">
					<div class="col-md-6 col-sm-6 hidden-xs">
						<p>Produk</p>
					</div>
					<div class="col-md-3 col-sm-3 hidden-xs">
						<p class="text-right">Harga</p>
					</div>
					<div class="col-md-3 col-sm-3 hidden-xs">
						<p class="text-right">Total</p>
					</div>    	
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-12">
						@if ($carts)
							<?php $total = 0; ?>
							@foreach ($carts as $k => $item)
								<?php
									$qty 			= 0;
									foreach ($item['varians'] as $key => $value) 
									{
										$qty 		= $qty + $value['qty'];
									}
								?>
								@include('widgets.checkout_item_list', array(
									"item_list_id"					=> $k,
									"item_list_image"				=> $item['images'],
									"item_list_name" 				=> $item['name'],
									"item_list_qty"					=> $qty,
									"item_list_normal_price"		=> $item['price'],
									"item_list_size"				=> $item['varians'],
									"item_list_discount_price"		=> $item['discount'],
									"item_list_total_price"			=> ($item['price']*$qty),
									"item_varians"					=> $item['varians'],
									"item_mode"						=> 'new',
								))
								<?php $total += ($item['price']*$qty); ?>
							@endforeach
						@else
							<div class="row chart-item">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h4 class="text-center">Tidak ada item di cart</h4>
								</div>
							</div>
						@endif

						<div class="row chart-topLine">
						</div>
					</div>
				</div>
				<!-- mobile -->
				<div class="row" style="background-color:black;">
					<div class="hidden-lg hidden-md hidden-sm col-xs-12" >
						<div class="row p-t-xs m-b-none">
							<div class="col-xs-12">
								<h3 style="color:#FFF;" class="text-center">SubTotal</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<h2 style="color:#fff;" class="text-center m-t-none">
									@if (isset($total))
										@money_indo($total)
									@endif
								</h2>
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>

				<!-- normal -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
						@if ($carts)
							<div class="row chart-footer">
								<div class="col-lg-9 col-md-9 col-sm-9">
									<h4 class="text-right">SubTotal :</h4>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-2">
									<h4 class="text-right">
										@if ($total)
											<strong>@money_indo($total)</strong>
										@endif
									</h4>
								</div>	
							</div>
						@endif
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-sm-offset-1">
			    {!! Form::open(['url' => route('frontend.post.checkout'), 'method' => 'POST']) !!}
			    	<div class="row">
			    		<div class="col-md-12">
			    			<h3 class="m-t-none m-b-md hollow-label">ALAMAT PENGIRIMAN</h3>
			    		</div>
			    	</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="hollow-label" for="name">Alamat Sebelumnya</label>
								<select class="form-control hollow" name="address_id">
									<option value="0">Alamat Baru</option>
									@foreach($addresses as $key => $value)
										<option value={{$value['id']}}>{{$value['receiver_name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="hollow-label" for="">Nama Penerima</label>
								{!! Form::input('text', 'receiver_name', null, [
										'class' 		=> 'form-control hollow transaction-input-postal-code',
								]) !!}
							</div>
							<div class="form-group">
								<label class="hollow-label" for="">Alamat</label>
								{!! Form::textarea('address', null, [
										'class' 		=> 'form-control hollow transaction-input-address',
										'rows'      => '2',
										'style'     => 'resize:none;',
								]) !!}
							</div>
							<div class="form-group">
								<label class="hollow-label" for="">Kode Pos</label>
								{!! Form::input('number', 'zipcode', null, [
										'class' 		=> 'form-control hollow transaction-input-postal-code',
								]) !!}
							</div>
							<div class="form-group">
								<label class="hollow-label" for="">No. Tlp</label>
								{!! Form::input('text', 'phone', null, [
										'class' 		=> 'form-control hollow transaction-input-phone',
								]) !!}
							</div>
						</div>
					</div>
					<div class="row">
			    		<div class="col-md-12">
			    			<h3 class="m-t-none m-b-md hollow-label">VOUCHER</h3>
			    		</div>
			    	</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="hollow-label" for="">Kode Voucher</label>
								{!! Form::input('text', 'voucher_code', null, [
										'class' 		=> 'form-control hollow transaction-input-voucher-code',
								]) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							</br>
							<div class="form-group text-right">
								<button type="submit" class="btn-hollow hollow-black-border" tabindex="7">Proses</button>
							</div>        
						</div>        
					</div>    
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop

@section('script')

@stop
