<div class="thumbnail">
	<img class="img img-responsive"  src="{{$data['default_image']}}" alt="">

	<div class="caption m-b-sm" >
		<h4 class="text-center">{{$data['name']}}</h4>
		<div class="info-price">
			@if ($data['stock']!=0)
				@if($data->promo_price!=0)
					<p class="text-center normal-price"><strike> @money_indo($data->price) </strike></p>
					<p class="text-center promo-price t-sm "> @money_indo($data->promo_price) </p>
				@else
					<p class="text-center promo-price t-sm "> @money_indo($data->price) </p>
				@endif
			@else
				<p class="text-center promo-price t-sm"> Out of Stock </p>
			@endif
		</div>
	</div>

	<a href="{{ route('frontend.product.show', $data['slug']) }}" type="button" class="btn-hollow hollow-black-border btn-block t-sm">DETAIL</a>
</div>
