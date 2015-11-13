<div class="thumbnail">
	<a href="{{ route('frontend.product.show', $data['slug']) }}" title="{{ $data['name'] }}">
		<img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
		<div class="hover"></div>
	</a>

	<div class="caption-card" >
		<a href="{{ route('frontend.product.show', $data['slug']) }}" title="{{ $data['name'] }}">
			<h4 class="text-center">
				{{ $data['name'] }}
			</h4>
			<div class="info-price">
				<?php $price 	= $data['price'];?>
				@if($data['discount']!=0)
					<p class="text-center normal-price"><strike> @money_indo($data['price']) </strike></p>
					<?php $price 	= $data['promo_price'];?>
				@endif
				@if($balance - $price >= 0)
					<p class="text-center normal-price"><strike> @money_indo($price) </strike></p>
					<?php $price 	= 0;?>
				@elseif($balance!=0)
					<p class="text-center normal-price"><strike> @money_indo($price) </strike></p>
					<?php $price 	= $price - $balance;?>
				@endif

				@if($price==$data->price)
					<p class="text-center normal-price"> @money_indo($price)</p>
				@else
					<p class="text-center promo-price t-sm"> @money_indo($price) </p>
				@endif
			</div>
		</a>
	</div>

	<a href="{{ route('frontend.product.show', $data['slug']) }}" type="button" class="btn-hollow hollow-black-border btn-block t-sm">DETAIL</a>
</div>
