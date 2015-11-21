<?php 	
	$carts = Session::get('baskets'); 
?>
@extends('template.frontend.layout')

@section('content')
	<div class="container m-t-md">
		<div class="row">
			<div class="col-lg-12">
				@include('widgets.breadcrumb')
				<div class="clearfix">&nbsp;</div>
				@include('widgets.alerts')
			</div>
		</div>
		{!! Form::open(['url' => route('frontend.post.checkout'), 'method' => 'POST']) !!}
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
					<div class="row m-t-sm">
						<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs checkout-bottom">
							@if ($carts)
								<div class="row">
									<div class="col-lg-8 col-md-8 col-sm-8 text-right">
										<span class="">Point Kamu</span>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4">
										<span class="text-right"></span>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-8 col-md-8 col-sm-8 text-right">
										<span >Biaya Pengiriman</span>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4">
										<span class="text-right"></span>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-8 col-md-8 col-sm-8 text-right">
										<span class="">Masukkan Kode Voucher</span>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 text-right">
										{!! Form::input('text', 'voucher_code', null, [
												'class' 		=> 'form-control hollow transaction-input-voucher-code',
										]) !!}
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-8 col-md-8 col-sm-8 text-right">
										<h4>SubTotal</h4>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4">
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
				<div class="col-xs-12 hidden-lg hidden-sm hidden-md">
					<div class="row clearfix">
						&nbsp;
					</div>
				</div>			
				<div class="col-sm-4 col-sm-offset-1">
			    	<div class="row">
			    		<div class="col-md-12">
			    			<h3 class="m-t-none m-b-md hollow-label">ALAMAT PENGIRIMAN</h3>
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
			    		</div>
			    	</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="hollow-label" for="name">Pilih Alamat</label>
								<select class="form-control hollow choice_address" name="address_id">
									@foreach($addresses as $key => $value)
										<option value={{$value['id']}}>{{$value['receiver_name']}}</option>
									@endforeach
									<option value="0">Tambah Alamat Baru</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row new-address new-address-hide">
						<div class="col-md-12">
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
							</br>
							<div class="form-group text-right">
								<button type="submit" class="btn-hollow hollow-black-border" tabindex="7">Checkout</button>
							</div>        
						</div>        
					</div>    
					
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('script')
	$('.choice_address').change(function() {
		var val = $(this).val();
		if (val == 0) {
			$('.new-address').removeClass('new-address-hide');
			$('.new-address').addClass('new-address-show');
		}
		else {
			$('.new-address').removeClass('new-address-show');
			$('.new-address').addClass('new-address-hide');
		}
	});
@stop
