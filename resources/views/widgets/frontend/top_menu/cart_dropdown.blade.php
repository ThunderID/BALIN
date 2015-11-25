<?php
	$carts = Session::get('baskets'); ;
?>
	
<ul class="dropdown-menu dropdown-menu-right chart-dropdown p-t-none" aria-labelledby="dLabel">
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
		<li class="border-top border-bottom text-center">
			<h4 class="p-t-md p-b-md m-t-none" style="text-transform:none; font-weight: 300; letter-spacing: 0.04em;">Belum ada item di Cart</h4>
		</li>

		<li class="" style="background-color: #000;
    color: #fff;">
			<div class="row">
				<div class="col-xs-12 text-center" style=" ">
					<h4 style="margin-bottom: 10px;
    font-weight: 500;
    font-size: 14px;
    letter-spacing: 0.1em;">Penawaran Kami</h4>
				</div>
			</div>
		</li>

		<?php
			$recom 		= Cache::remember('recommended_batik', 30, function() 
			{
						return App\Models\Product::currentprice(true)->DefaultImage(true)->sellable(true)->orderby('products.created_at','desc')->take(2)->get();
			});

		?>
		@foreach($recom as $k => $item)
			<li class="@if(count($recom)>($k+1)) border-bottom @endif">
				@include('widgets.frontend.cart.cart_recommended', [
					'label_id'				=> $k,
					'label_image'			=> $item['default_image'],
					'label_name'			=> $item['name'],
					'label_price'			=> $item['price'],
					'label_qty'				=> $item['varians'],
					'label_promo'			=> $item['promo_price'],
					'label_slug'			=> $item['slug'],
				])
			</li>
		@endforeach
	@endif                                                                
</ul>