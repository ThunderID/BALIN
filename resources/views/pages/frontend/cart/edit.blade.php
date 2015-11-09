<?php 	
	$carts = Cookie::get('baskets');
?>
@extends('template.frontend.layout')

@section('content')
	<div class="container mt-75">
		<div class="row">
			<div class="col-lg-12">
				@include('widgets.pageelements.pagetitle', array('pagetitle' => 'Cart'))
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			@if (Auth::User())
				<div class="col-md-2 col-lg-2 col-sm-3 hidden-xs">              		
					@include('widgets.frontend.profile.my_profile_menu')
				</div>
			@endif
			<div class="@if(Auth::User()) col-md-10 col-lg-10 col-sm-9 @else col-xs-12 col-md-12 col-sm-12 @endif">
				<div class="row">
					<div class="col-md-12">
						<div class="row chart-header">
							<div class="col-md-4 col-sm-4 hidden-xs">
								<p>Produk</p>
							</div>
							<div class="col-md-1 col-sm-1 hidden-xs">
								<p class="text-center">Qty</p>
							</div>
							<div class="col-md-2 col-sm-2 hidden-xs">
								<p class="text-right">Harga</p>
							</div>
							<div class="col-md-2 col-sm-2 hidden-xs">
								<p class="text-right">Diskon</p>
							</div>
							<div class="col-md-2 col-sm-2 hidden-xs">
								<p class="text-right">Total</p>
							</div>
							<div class="col-md-1 col-sm-1 hidden-xs">
								<p></p>
							</div>        	
						</div>
						
						@if ($carts)
							<?php $total = 0; ?>
							@foreach ($carts as $k => $item)
								@include('widgets.cart_item_list', array(
									"item_list_id"					=> $k,
									"item_list_image"				=> $item['images'],
									"item_list_name" 				=> $item['name'],
									"item_list_sku" 				=> $item['sku'], 
									"item_list_qty"				=> $item['qty'],
									"item_list_normal_price"	=> $item['price'],
									"item_list_promo_price"		=> $item['promo_price'],
									"item_list_discount_price"	=> $item['discount'],
									"item_list_total_price"		=> ($item['price']*$item['qty']),
									'item_list_stock'				=> $item['stock'],
									"item_mode"						=> 'edit',
								))
								<?php $total += ($item['price']*$item['qty']); ?>
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
						<div class="row">
							<div class="col-xs-12">
								<a href="#" class="btn-hollow hollow-white btn-block">
									Update Cart
								</a>
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
						<div class="row">
							<div class="col-xs-12">
								<a href="#" class="btn-hollow hollow-white btn-block">
									Checkout
								</a>
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
						<div class="clearfix">&nbsp;</div>
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
								<div class="col-lg-2 col-md-2 col-sm-2">
									<h4 class="text-right">
										@if ($total)
											@money_indo($total)
										@endif
									</h4>
								</div>	
							</div>
						@endif
						<div class="clearfix">&nbsp;</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<a href="#" class="btn-hollow hollow-black pull-right m-r-sm">
									Batal
								</a>
								<a href="{{ route('frontend.cart.store') }}" class="btn-hollow hollow-black pull-right m-r-sm">
									Simpan
								</a>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="clearfix">&nbsp;</div>
						</div>
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop

@section('script')
	$('.product-qty').change( function(e) {
		e.preventDefault;
		var total								= 0;
		var product_price						= parseInt($(this).parent().parent().parent().find('.label-price').attr('data-product-price')); 
		var product_promo_price				= parseInt($(this).parent().parent().parent().find('.label-promo-price').attr('data-product-promo-price')); 
		var product_discount_price			= parseInt($(this).parent().parent().parent().find('.label-discount-price').attr('data-product-discount-price'));
		var product_qty						= parseInt($(this).val());
		
		total 									=  product_qty*product_price;
		$(this).parent().parent().parent().find('.label-total').text('Rp '+number_format(total));
	});
@stop
