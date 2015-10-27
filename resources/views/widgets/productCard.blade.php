    <div class="thumbnail">
        <img class="img img-responsive"  src="{{$data['default_image']}}" alt="">

        <div class="caption">
            <h4 class="text-center">{{$data['name']}}</h4>
            <p class="text-center normal-price">Normal Price : {{$data->price}}</p>
            <p class="text-center promo-price">Promo Price : {{$data->promoprice}}</p>
        </div>

        <a href="{{ route('frontend.product.show', $data['id']) }}" type="button" class="btn btn-default btn-block"><h4>Detail</h4></a>
    </div>
