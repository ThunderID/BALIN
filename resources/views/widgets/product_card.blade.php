<div class="thumbnail">
	<a href="{{ route('frontend.product.show', $data['slug']) }}" title="{{ $data['name'] }}">
		<img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
		<div class="hover"></div>
		@if (count($data->lables)!=0)
			<div class="tag-label">
				@foreach ($data->lables as $label)
					<?php
						switch (str_replace('_', '', strtoupper($label['lable']))) {
							case "SALE":
								// echo "<div class='circle-label black'><div>SALE</div></div>";
								echo "<div class='square-label black'><div>SALE</div></div>";
								break;
							case "HOTITEM":
								// echo "<div class='circle-label black'><div><p style='margin-top: -6px;''>HOT ITEM</p></div></div>";
								echo "<div class='square-label black'><div>HOT ITEM</div></div>";
								break;	
							case "BESTSELLER":
								// echo "<div class='circle-label black'><div><p style='margin-top: -6px; font-size: 12px;'>BEST SELLER</p></div></div>";
								echo "<div class='square-label black'><div>BEST SELLER</div></div>";
								break;															
							default:
								// echo "<div class='circle-label black'><div><p style='margin-top: -6px; font-size: 12px;'>" . str_replace('_', ' ', strtoupper($label['lable'])) . "</p></div></div>";
								echo "<div class='square-label black'><div>" . str_replace('_', ' ', strtoupper($label['lable'])) . "</div></div>";
								break;
						}
					?>
				@endforeach
			</div>
		@endif
		
			{{-- <div class="tag-sale" style="">
				<p style="">Beli 2 Gratis 1</p>
			</div> --}}
	</a>

	<div class="caption-card m-t-0" >
		<a href="{{ route('frontend.product.show', $data['slug']) }}" title="{{ $data['name'] }}">
 			<div class="info-product">
				<h4 class="text-center">
					{{ $data['name'] }}
				</h4>
			</div>
		</a>
		<div class="info-price">
			<a href="{{ route('frontend.product.show', $data['slug']) }}" title="{{ $data['name'] }}">
			<?php $price 	= $data['price']; ?>

			@if($data['discount']!=0)
				<span class="text-center normal-price small-price">
					@money_indo($data['price'])
					<?php $price 	= $data['promo_price'];?>
				</span>
			@else
				<p class="text-center normal-price">
					&nbsp;
				</p>
			@endif

			@if($price==$data->price)
				<p class="text-center normal-price"> @money_indo($price)</p>
			@else
				<p class="text-center promo-price"><strong>@money_indo($price) </strong></p>
			@endif
			</a>
		</div>
	</div>

	<a href="{{ route('frontend.product.show', $data['slug']) }}" type="button" class="btn-hollow hollow-black-border btn-block t-sm detail">DETAIL</a>
</div>
