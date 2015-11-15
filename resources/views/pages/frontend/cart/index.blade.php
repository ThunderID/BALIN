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
			
			<div class="col-xs-12 col-md-12 col-sm-12">
				<div class="row">
					<div class="col-md-12">
						<div class="row chart-header">
							<div class="col-md-4 col-sm-4 hidden-xs">
								<p>Produk</p>
							</div>
							<div class="col-md-1 col-sm-1 hidden-xs">
								<p class="text-center">Kuantitas</p>
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
						<div class="row">
							<div class="col-xs-12">
								<a href="{{ route('frontend.product.index') }}" class="btn-hollow hollow-white btn-block">
									Lanjut Belanja
								</a>
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
						<div class="row">
							<div class="col-xs-12">
								<a href="{{ route('frontend.get.checkout') }}" class="btn-hollow hollow-white btn-block">
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
											<strong>@money_indo($total)</strong>
										@endif
									</h4>
								</div>	
							</div>
						@endif
						<div class="clearfix">&nbsp;</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<a href="{{ route('frontend.product.index') }}" class="btn-hollow hollow-black-border pull-right m-r-sm">
									Lanjut Belanja
								</a>
								<a href="{{ route('frontend.get.checkout') }}" class="btn-hollow hollow-black-border pull-right m-r-sm">
									Checkout
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

@section('script_plugin')
	@include('plugins.qty-hollow')
@stop
