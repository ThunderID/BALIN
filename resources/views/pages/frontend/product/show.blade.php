@inject('product', 'App\Models\Product')
<?php 
	 $data          = $product->where('slug', $slug)->first();

	$related 		= $product->notid($data->id)->take(4)->get();
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container mt-75">
		<div class="row">
			<div class="col-lg-12 m-b-md">
				@include('widgets.breadcrumb')
			</div>
		</div>
		<div class="row">
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-7 col-md-offset-3 text-center hidden-xs hidden-sm">
						<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails m-t-md" style="width:100%; border:1px solid #eee">
							<a class="img-large" href="{{ str_replace('.jpg', '-large.jpg', $data['default_image']) }}" >
								<img class="img img-responsive myCanvas"  src="{{ $data['default_image'] }}" style="width:100%">
							</a>
						</div>
					 </div>
				</div>
				<div class="row">
					<div class="col-md-7 col-md-offset-3">
						<div class="owl-carousel gallery-product">
							@for ($i = 0; $i < 7; $i++)
								<div class="item">
									<a href="{{ str_replace('.jpg', '-large.jpg', $data['default_image']) }}" data-standard="{{ $data['default_image'] }}">
										<img class="img img-responsive canvasSource" id="canvasSource{{$i}}" src="{{$data['default_image']}}" alt="">
									</a>
								</div>
							@endfor					    	     
						</div>      
					</div>        				
				</div>
			</div>
			<div class="col-md-5">
				<div class="row">
					<div class="col-md-12">
						<h3 style="font-size:28px; font-weight:300">{{ $data['name'] }}</h3>
						<div class="clearfix">&nbsp;</div>
						<?php $price 	= $data->price;?>
						@if($data->discount!=0)
							<h4><strike> @money_indo($data->price) </strike></h4>
							<?php $price 	= $data->promo_price;?>
						@endif
						@if($balance - $price >= 0)
							<h4><strike> @money_indo($price) </strike></h4>
							<?php $price 	= 0;?>
						@elseif($balance!=0)
							<h4><strike> @money_indo($price) </strike></h4>
							<?php $price 	= $price - $balance;?>
						@endif

						@if($price==$data->price)
							<h4> @money_indo($price)</h4>
						@else
							<h4> @money_indo($price) </h4>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						{!! Form::open(['url' => route('frontend.cart.store'), 'class' => 'p-t-sm form']) !!}
							@if ($data['stock']==0)
								<div class="row">
									<div class="col-md-12 m-b-md">
										<h4 class="text-center out-of-stock">
											Sorry,</br>
											Out of Stock
										</h4>
									</div>
								</div>
							@else
								<div class="row">
									<div class="col-md-12">
										{!! Form::hidden('product_slug', $slug) !!}
										<div class="form-group">
											<label for="name">Qty</label>
											<div class="row">
												<div class="col-xs-12 col-sm-10 col-md-8">
													<select name="product_qty" class="form-control hollow">
														@for($x=1; $x<=10; $x++)
															@if ($x<=$data['stock'])
																<option value="{{ $x }}">{{ $x }}</option>
															@endif
														@endfor
													</select>
												</div>
												<div class="col-xs-12 col-sm-2 col-md-4" style="">
													{!! Form::submit('Add to Cart', ['class' => 'btn-hollow hollow-black-border']) !!}
												</div>
											</div>
										</div>	
									</div>	
								</div>
								<div class="clearfix">&nbsp;</div>
							@endif
						{!! Form::close() !!}
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h4>Deskripsi</h4>
						<p>{{ $data['description'] }}</p>     
					</div> 					        				
				</div>
				<div class="clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-md-12">
						<p class="tag-categories">
							<i class = "fa fa-tags"></i>
							@foreach ($data['categories'] as $key => $value)
								@if ($key!=0)
									,
								@endif
								<a href="{{route('frontend.product.index', ['q' => $value['name']])}}"> {!! $value['name'] !!}</a>
							@endforeach
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
	$(document).ready(function() {
		$('.canvasSource').click(function() {
			  /* var image = $(this).attr('src');
			  var image_replace = image.replace('.jpg', '-large.jpg');
			  console.log(image_replace);
			  $('img.myCanvas').attr('src', image);
			  $('a.img-large').attr('href', image_replace); */
		 });    
	});  
@stop

@section('script_plugin')
	@include('plugins.owlCarousel')
	@include('plugins.easyzoom')
@stop
