@inject('data', 'App\Models\Product')
<?php $data = $data::where('id', $id)
									->with('categories')
									->with('images')
									->first(); 

?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Produk
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					@foreach ($data->images as $k => $img)
						@if ($k==5)
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						@endif
						{!! HTML::image($img->image_xs) !!}
					@endforeach
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<h2 style="margin-top:0px;">{!!$data->name!!}</h2>
			<h5><strong>SKU</strong> {!!$data->sku!!}</h5>
			<h5><strong>Stok</strong> {!!$data->stock!!}</h5>
			<h5><strong>Harga</strong> @if($data->discount!=0)<strike> {!!$data->price!!} </strike> {!!$data->promo_price!!} @else {!!$data->price!!} @endif</h5>
			<h5><strong>Diskon</strong> {!!$data->discount!!}</h5>
			<i class = "fa fa-tags"></i>
			@foreach($data->categories as $key => $value)
				@if($key!=0)
					,
				@endif
				{!! $value->name !!}
			@endforeach
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			{!!$data->description!!}
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop