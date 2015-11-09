<?php
	$carts = Cookie::get('baskets');
?>
@if ($carts)
	<ul class="dropdown-menu dropdown-menu-right chart-dropdown m-t-md" aria-labelledby="dLabel" style="margin-top:3px">
		<?php $total = 0; ?>
		@foreach ($carts as $k => $item)
			@if ($k==0)
				<li class="chart-dropdown-item-grid">
					@include('widgets.frontend.cart.cart_item', array(
						'label_image'			=> $item['images'],
						'label_name'			=> $item['name'],
						'label_qty'				=> $item['qty'],
						'label_price'			=> $item['price'],
						'label_total'			=> $item['qty']*$item['price']
					))
				</li>
			@else
				<li class="chart-lowLine">
					@include('widgets.frontend.cart.cart_item', array(
						'label_image'			=> $item['images'],
						'label_name'			=> $item['name'],
						'label_qty'				=> $item['qty'],
						'label_price'			=> $item['price'],
						'label_total'			=> $item['qty']*$item['price']
					))
				</li>                        
			@endif
			<?php $total += ($item['price']*$item['qty']); ?>
		@endforeach

		<li class="chart-dropdown-subtotal chart-lowLine">
			<div class="row">
				<div class="col-sm-12" style="margin:5px;">
					<p class="text-center">SUBTOTAL <Span style="font-weight:400;margin-left:25px;">@money_indo($total)</span></p>
				</div>
			</div>
		</li>  
		<li>
			<div class="row">
				<div class="col-xs-12 text-center" style=" ">
					<a href="{{ URL::route('frontend.cart.index') }}" class="btn-hollow btn-hollow-sm hollow-black">Show Cart</a>
					<a href="#" class="btn-hollow btn-hollow-sm hollow-black">Checkout</a>
				</div>
			</div>
		</li> 
	</ul>
@endif                                                                