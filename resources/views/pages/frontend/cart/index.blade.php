<?php 	
	$carts = Session::get('baskets');
?>
@extends('template.frontend.layout')

@section('content')
	<div class="container m-t-sm">
		<div class="row">
			<div class="col-lg-12">
				@include('widgets.breadcrumb')
				@include('widgets.pageelements.pagetitle', ['pagetitle' => ''])
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-sm-12 chart-div">
				<div class="row chart-header">
					<div class="col-sm-2 col-md-1 hidden-xs">
						<p>Produk</p>
					</div>
					<div class="col-sm-10 col-md-11 hidden-xs">
						<div class="row">
							<div class="col-sm-2 col-md-3"></div>
							<div class="col-sm-3 col-md-3 text-right p-r-none">
								<p class="text-center" style="margin-left: -35px; !important">Kuantitas</p>
							</div>
							<div class="col-sm-2 col-md-2">
								<p class="text-right">Harga</p>
							</div>
							<div class="col-sm-2 col-md-2">
								<p class="text-right">Diskon</p>
							</div>
							<div class="col-sm-3 col-md-2">
								<p class="text-right">Total</p>
							</div> 	
						</div>
					</div>
				</div>
			
				<?php $total = 0;?>
				@if (!empty($carts))
					@foreach ($carts as $k => $item)
						<?php
							$qty 			= 0;
							foreach ($item['varians'] as $key => $value) 
							{
								$qty 		= $qty + $value['qty'];
							}
						?>
						@include('widgets.cart_item_list', array(
							"item_list_id"					=> $k,
							"item_list_image"				=> $item['images'],
							"item_list_name" 				=> $item['name'],
							"item_list_qty"					=> $qty,
							"item_list_normal_price"		=> $item['price'],
							"item_list_size"				=> $item['varians'],
							"item_list_discount_price"		=> $item['discount'],
							"item_list_total_price"			=> (($item['price']-$item['discount'])*$qty),
							"item_varians"					=> $item['varians'],
							"item_list_slug"				=> $item['slug'],
							"item_mode"						=> 'new',
						))
						<?php $total += (($item['price']-$item['discount'])*$qty); ?>
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
		<div class="row hidden-lg hidden-md hidden-sm" style="background-color:black; border-bottom:1px solid rgba(255, 255, 255, 0.2)">
			<div class="col-xs-12" >
				@if (!empty($carts))
					<div class="row p-t-xs m-b-none empty-cart-mobile">
						<div class="col-xs-12">
							<h3 style="color:#FFF;" class="text-center">SubTotal</h3>
						</div>
					</div>
					<div class="row empty-cart-mobile">
						<div class="col-xs-12">
							<h2 style="color:#fff;" class="text-center m-t-none total-all grand-total-mobile" data-get-total="{{ $total }}">
								@if (isset($total))
									@money_indo($total)
								@endif
							</h2>
						</div>
					</div>
				@endif
				<div class="clearfix">&nbsp;</div>
				@if (!empty($carts))
				<!-- 	<div class="row empty-cart-mobile">
						<div class="col-xs-12">
							<a href="{{ route('frontend.cart.empty') }}" class="btn-hollow hollow-white btn-block">
								Kosongkan Cart
							</a>
						</div>
					</div>
					<div class="clearfix">&nbsp;</div> -->
				@endif
				<div class="row">
					<div class="col-xs-12">
						<a href="{{ route('frontend.product.index') }}" class="btn-hollow hollow-white btn-block">
							Pilih Produk Lain
						</a>
					</div>
				</div>
				@if (!empty($carts))
					<div class="clearfix">&nbsp;</div>
					<div class="row empty-cart-mobile">
						<div class="col-xs-12">
							<a href="{{ route('frontend.get.checkout') }}" class="btn-hollow hollow-white btn-block">
								Checkout
							</a>
						</div>
					</div>
				@endif
				<div class="clearfix">&nbsp;</div>
				<div class="clearfix">&nbsp;</div>
			</div>
		</div>

		<!-- normal -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
				@if (!empty($carts))
					<div class="row">
						<div class="col-sm-1 col-md-1">
						</div>
						<div class="col-sm-11 col-md-11">
							<div class="row chart-footer">
								<div class="col-md-9 col-sm-9">
									<h4 class="text-right">SubTotal :</h4>
								</div>
								<div class="col-md-3 col-sm-3">
									<h4 class="text-right label-total-all grand-total" data-total-item="{{ $total }}">
										@if ($total)
											<strong>@money_indo($total)</strong>
										@endif
									</h4>
								</div>	
							</div>
						</div>
					</div>
				@endif
				<div class="clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
						<div class="row">
							<a href="{{ route('frontend.product.index') }}" class="link-black hover-gray unstyle pull-left m-r-sm">
								<strong>Pilih Produk Lain</strong>
							</a>
							@if (!empty($carts))
								<a href="{{ route('frontend.get.checkout') }}" class="btn-hollow hollow-black-border pull-right m-r-sm empty-cart">
									Checkout
								</a>
<!-- 								<a href="{{ route('frontend.cart.empty') }}" class="btn-hollow hollow-black-border pull-right m-r-sm empty-cart">
									Kosongkan Cart
								</a> -->				
							@endif				
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="clearfix">&nbsp;</div>
				</div>
				<div class="clearfix">&nbsp;</div>
			</div>
		</div>
	</div>
	<div class="hidden-xs">
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
	</div>
@stop

@section('script')
	
	//var total_all = 0;
	//$('.label-total').change( function() {
		//var total_cart = $(this).html('data-total');
		// var total_all = $.map($(".pqty"), function(elt) { return elt.val;});

		//console.log(total_cart);
	//});
@stop

@section('script_plugin')
	@include('plugins.cart-plugin')
	@include('plugins.form_no_enter')
@stop
