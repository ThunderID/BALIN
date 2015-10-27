<div class="thumbnail">
	<img class="img img-responsive"  src="{{$data['default_image']}}" alt="">

	<div class="caption m-b-md">
		<h4 class="text-center">{{$data['name']}}</h4>
		@if($data->promo_price!=0)
			<p class="text-center normal-price"><strike>Rp {{$data->price}}</strike></p>
			<p class="text-center promo-price t-md">Rp {{$data->promo_price}}</p>
		@else
			<p class="text-center promo-price t-md">Rp {{$data->price}}</p>
		@endif
	</div>

	<a href="{{ route('frontend.product.show', $data['id']) }}" type="button" class="btn-hollow hollow-black btn-block t-md">Detail</a>
</div>
