<?php
	$carts = Session::get('baskets');
?>
	@if (!empty($carts))
		<?php $total = 0; $i=0; ?>
		<div class="cart-content">
			@foreach ($carts as $k => $item)
				<?php
					$qty 			= 0;
					foreach ($item['varians'] as $key => $value) 
					{
						$qty 		= $qty + $value['qty'];
					}
				?>
				@if ($k==0)
					<li class="chart-dropdown-item-grid border-bottom dashed">
						@include('widgets.frontend.cart.cart_item', [
							'label_id'				=> $k,
							'label_image'			=> $item['images'],
							'label_name'			=> $item['name'],
							'label_qty'				=> $item['varians'],
							'label_price'			=> $item['price'],
							'label_total'			=> $qty*$item['price']
						])
					</li>
				@else
					<li class="@if(count($carts)>($i+1)) border-bottom dashed @endif">
						@include('widgets.frontend.cart.cart_item', [
							'label_id'				=> $k,
							'label_image'			=> $item['images'],
							'label_name'			=> $item['name'],
							'label_qty'				=> $item['varians'],
							'label_price'			=> $item['price'],
							'label_total'			=> $qty*$item['price']
						])
					</li>
				@endif
				<?php $total += ($item['price']*$qty); $i++; ?>
			@endforeach
		</div>
		<div class="cart-bottom">
			<div class="cart-divider">&nbsp;</div>
			<li class="chart-dropdown-subtotal border-top border-bottom">
				<div class="row">
					<div class="col-sm-12">
						<p class="text-center">SUBTOTAL <span class="m-l-md" style="font-weight:400;">@money_indo($total)</span></p>
					</div>
				</div>
			</li>  
			<li>
				<div class="row">
					<div class="col-xs-12 text-center" style=" ">
						<a href="{{ route('frontend.cart.index') }}" class="btn-hollow btn-hollow-sm hollow-black-border m-r-sm">Lihat Cart</a>
						<a href="{{ route('frontend.get.checkout') }}" class="btn-hollow btn-hollow-sm hollow-black-border m-l-sm">Checkout</a>
					</div>
				</div>
			</li> 
		</div>
	@else
		<li class="chart-dropdown-item-grid">&nbsp;</li>
		<li class=" chart-lowLine">
			<div class="row">
				<div class="col-xs-12 text-center" style=" ">
					<h4>No Cart</h4>
				</div>
			</div>
		</li>
	@endif                                                                