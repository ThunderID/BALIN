    <div class="thumbnail">
        <img class="img img-responsive"  src="{{$data['default_image']}}" alt="">

        <div class="caption">
            <h4 class="text-center">{{$data['name']}}</h4>
            @if($data->promo_price!=0)
	            <p class="text-center normal-price"><strike>Rp {{$data->price}}</strike></p>
	            <p class="text-center promo-price">Rp {{$data->promo_price}}</p>
	        @else
	            <p class="text-center normal-price">Rp {{$data->price}}</p>
	        @endif
        </div>

        <a href="{{ route('frontend.product.show', $data['id']) }}" type="button" class="btn btn-default btn-block"><h4>Detail</h4></a>
    </div>
