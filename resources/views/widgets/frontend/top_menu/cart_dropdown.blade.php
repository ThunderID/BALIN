<?php
	$carts = Cookie::get('baskets');
?>
<ul class="dropdown-menu dropdown-menu-right chart-dropdown m-t-md" aria-labelledby="dLabel" style="margin-top:3px">
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
			@if ($k==0)
				<li class="chart-dropdown-item-grid">
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
				<li class="chart-lowLine">
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
			<?php $total += ($item['price']*$qty); ?>
		@endforeach

		<li class="chart-dropdown-subtotal chart-lowLine">
			<div class="row">
				<div class="col-sm-12" style="margin:5px;">
					<p class="text-center">SUBTOTAL <span class="m-l-md" style="font-weight:400;">@money_indo($total)</span></p>
				</div>
			</div>
		</li>  
		<li>
			<div class="row">
				<div class="col-xs-12 text-center" style=" ">
					<a href="{{ URL::route('frontend.cart.index') }}" class="btn-hollow btn-hollow-sm hollow-black-border m-r-sm">Lihat Cart</a>
					<a href="#" class="btn-hollow btn-hollow-sm hollow-black-border m-l-sm">Checkout</a>
				</div>
			</div>
		</li> 
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
</ul>