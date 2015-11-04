@inject('datas', 'App\Models\Product')
<?php 	

?>
@extends('template.frontend.layout')

@section('content')
    <div class="container mt-75">
        <div class="row">
            <div class="col-lg-12">
                @include('widgets.pageelements.pagetitle', array('pagetitle' => 'Shopping Cart'))
            </div>
        </div>
	    <div class="clearfix">&nbsp;</div>
        <div class="row">
			<div class="col-md-12">
				<div class="row chart-header">
		        	<div class="col-md-4 col-sm-4 hidden-xs">
		        		<p>Product</p>
		        	</div>
		        	<div class="col-md-1 col-sm-1 hidden-xs">
		        		<p class="text-center">Qty</p>
		        	</div>
		        	<div class="col-md-2 col-sm-2 hidden-xs">
		        		<p class="text-right">Price (Rp)</p>
		        	</div>
		        	<div class="col-md-2 col-sm-2 hidden-xs">
		        		<p class="text-right">Discount (Rp)</p>
		        	</div>
		        	<div class="col-md-2 col-sm-2 hidden-xs">
		        		<p class="text-right">Total (Rp)</p>
		        	</div>
		        	<div class="col-md-1 col-sm-1 hidden-xs">
		        		<p></p>
		        	</div>        	
	        	</div>
	        	
	        	@if ($carts)
	        		<?php $total = 0; ?>
	        		@foreach ($carts as $k => $item)
				        @include('widgets.cart_item_list', array(
				        	"itemIDCart"			=> $k,
				        	"itemListImage"			=> $item['images'],
							"itemListName" 			=> $item['name'],
							"ItemListSku" 			=> $item['sku'], 
							"itemListQty"			=> $item['qty'],
							"itemListNormalPrice"	=> $item['price'],
							"itemListPromoPrice"	=> $item['promo_price'],
							"itemListDiscountPrice"	=> $item['discount'],
							"itemListTotalPrice"	=> ($item['price']*$item['qty'])
				        ))
				        <?php $total += ($item['price']*$item['qty']); ?>
	        		@endforeach
	        	@else
	        		<div class="row chart-item">
	        			<div class="col-md-12 col-sm-12 col-xs-12">
			        		<h4 class="text-center">No item in cart</h4>
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
				</br>
				<div class="row" style="padding-top:5px; margin-bottom:0px;">
					<div class="col-xs-12">
						<h3 style="color:#FFF;" class="text-center">SubTotal(Rp)</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h2 style="color:#FFF; margin-top:0px;" class="text-center">10.000.000</h2>
					</div>
				</div>				
				</br>
				<div class="row">
					<div class="col-xs-12">
				        <button type="button" class="btn btn-lg btn-info btn-block">
				        	Update Cart
				        </button>
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-xs-12">
				        <button type="button" class="btn btn-lg btn-success btn-block">
				        	Checkout
				        </button>
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
							<h4 class="text-right">SubTotal(Rp) :</h4>
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
				        <button style="margin-right:10px;"type="button" class="btn-hollow hollow-black pull-right">
				        	Checkout
				        </button>
				        <button style="margin-right:10px;"type="button" class="btn-hollow hollow-black pull-right">
				        	Update Cart
				        </button>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="clearfix">&nbsp;</div>
				</div>
				<div class="clearfix">&nbsp;</div>
			</div>
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
@stop

@section('script')

@stop
