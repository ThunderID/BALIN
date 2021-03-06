<div class="thumbnail">
	<a href="{{ route('frontend.product.show', $data['slug']) }}" title="{{ $data['name'] }}">
		<img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
		<div class="hover"></div>
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
