@inject('product', 'App\Models\Product')
<?php 
	$data          = $product->slug($slug)->sellable(true)->with('varians')->with('images')->first();
	$related 		= $product->notid($data['id'])->sellable(true)->currentprice(true)->DefaultImage(true)->take(4)->get();
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container mt-75 m-b-xl">
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
							@foreach ($data['images'] as $k => $v)
								<div class="item">
									<a href="{{ str_replace('.jpg', '-large.jpg', $v['image_md']) }}" data-standard="{{ $v['image_md'] }}">
										<img class="img img-responsive canvasSource" id="canvasSource{{$k}}" src="{{$v['image_md']}}" alt="">
									</a>
								</div>
							@endforeach
						</div>      
					</div>        				
				</div>
			</div>
			<div class="col-md-5 product-info">
				<div class="row">
					<div class="col-md-12">
						<h3 class="title-product caption-product">{{ $data['name'] }}</h3>
						<div class="clearfix">&nbsp;</div>
						{{-- <h4 class="caption-product">Price</h4> --}}
						<?php $price 	= $data['price'];?>
						@if($data['discount']!=0)
							<h4 class="text-product"><strike> @money_indo($data['price']) </strike></h4>
							<?php $price 	= $data['promo_price'];?>
						@endif
						@if($balance - $price >= 0)
							<h4 class="text-product"><strike> @money_indo($price) </strike></h4>
							<?php $price 	= 0;?>
						@elseif($balance!=0)
							<h4 class="text-product"><strike> @money_indo($price) </strike></h4>
							<?php $price 	= $price - $balance;?>
						@endif

						@if($price==$data['price'])
							<h4 class="text-product"> @money_indo($price)</h4>
						@else
							<h4 class="text-product"> @money_indo($price) </h4>
						@endif
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-md-12">
						<h4 class="caption-product">Deskripsi</h4>
						<p class="text-product">{!! $data['description'] !!}</p>
					</div> 					        				
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h4 class="caption-product">Ukuran & Fit</h4>
						<p class="text-product">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur ratione voluptatem fugiat ipsam explicabo repellat optio beatae corrupti obcaecati deleniti, laborum dolores. Placeat dolorem ipsam nostrum, inventore iste accusamus similique?</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						{!! Form::open(['url' => 'javascript:void(0);', 'class' => 'p-t-sm form-addtocart']) !!}
							<?php $stock = $data['current_stock'];?>
							@if ($stock==0)
								<div class="row">
									<div class="col-md-12 m-b-md">
										<h4 class="text-center out-of-stock">
											Sorry,</br>
											Out of Stock
										</h4>
									</div>
								</div>
							@else
								{!! Form::hidden('product_slug', $slug, ['class' => 'pslug']) !!}
								{!! Form::hidden('product_name', $data['name'], ['class' => 'pname']) !!}
								{!! Form::hidden('product_price', $price, ['class' => 'pprice']) !!}
								{!! Form::hidden('product_discount', $data['discount'], ['class' => 'pdiscount']) !!}
								{!! Form::hidden('product_stock', 0, ['class' => 'prod_stock pstock']) !!}
								{!! Form::hidden('product_image', $data['default_image'], ['class' => 'pimage']) !!}
								{!! Form::hidden('product_size', '', ['class' => 'prod_size psize']) !!}

								@include('widgets.alerts')
								<div class="row text-center m-t-xl">
									@foreach($data['varians'] as $k => $v)
										@if ($k<=2)
											<div class="col-sm-12 col-md-4 text-center">
												<div class="form-group">
													<div class="qty-hollow m-b-lg">
														<label class="label-qty">{{ $v['size'] }}</label>
													  	<input type="hidden" name="varianids[{{$k}}]" class="form-control pvarians" value="{{$v['id']}}">
													  	<input type="text" name="qty[{{$k}}]" class="form-control hollow form-qty input-number pqty" value="0" min="0" max="@if(50<=$v['stock']){{'50'}}@else{{ $v['stock'] }}@endif" data-stock="{{ $v['stock'] }}" data-id="{{ $v['id'] }}" data-name="qty-{{strtolower($v['size'])}}[1]" data-oldValue="">
														<button type="button" class="btn-hollow btn-hollow-sm btn-qty qty-minus btn-number" disabled="disabled" data-type="minus" data-field="qty-{{strtolower($v['size'])}}[1]">
															<i class="fa fa-minus"></i>
													  	</button>
													  	<button type="button" class="btn-hollow btn-hollow-sm btn-qty qty-plus btn-number" data-type="plus" data-field="qty-{{strtolower($v['size'])}}[1]">
														  	<i class="fa fa-plus"></i>
													  	</button>
													</div>
												</div>
											</div>
										@endif
									@endforeach
								</div>
								<div class="row m-t-xl">
									<div class="col-sm-12">
										<div class="qty-total">
											<h4 class="pull-left m-t-sm caption-product">
												Total
											</h4>
											<?php $price 	= $data['price'];?>
											<label class="text-right m-t-xs text-product tot_qty" data-price="{{ $price }}"> @money_indo('0')</label> 
										</div>
									</div>
								</div>
								<div class="row m-t-sm">
									<div class="col-sm-4">
										<div class="fb-share-button" data-href="{{ route('frontend.product.show', $data['slug']) }}" data-layout="button_count"></div>
									</div>
									<div class="col-sm-8">
										<div class="form-group text-right">
											{!! Form::submit('ADD TO CART', ['class' => 'btn-hollow hollow-black-border addto-cart']) !!}
										</div>	
									</div>	
								</div>
								<div class="clearfix">&nbsp;</div>
							@endif
						{!! Form::close() !!}
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
				{{-- <div class="row">
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
				</div> --}}
			</div>
		</div>
		@if ($related)
			<div class="row m-t-lg m-b-md related-product">
				<div class="col-sm-12">
					<h4>Produk Lainnya</h4>
				</div>
			</div>
			<div class="row">
					@foreach($related as $data)
						<div class="col-sm-4 col-md-3">
							@include('widgets.product_card')
						</div>
					@endforeach
				</div>
			
		@endif
	</div>
	<div id="fb-root"></div>
@stop

@section('script')
	(function(d, s, id) {
	 	var js, fjs = d.getElementsByTagName(s)[0];
	 	if (d.getElementById(id)) return;
	 	js = d.createElement(s); js.id = id;
	 	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
	 	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));


	$(document).ready(function() {
		$('.canvasSource').click(function() {
			  /* var image = $(this).attr('src');
			  var image_replace = image.replace('.jpg', '-large.jpg');
			  console.log(image_replace);
			  $('img.myCanvas').attr('src', image);
			  $('a.img-large').attr('href', image_replace); */
		 });

		<!-- Get Stock Varian -->
		$('.select_varian').on('change', function() {
			var stock 	= $(this).find(':selected').data('stock');
			var size 	= $(this).find(':selected').text();
			var sel_qty = $('.select_qty');
			
			sel_qty.find('option').remove();
			sel_qty.append($("<option>").attr("value", "").text("Pilih Kuantitas").attr("disabled", "disabled"));
			for (var i=1; i<=10; i++ ) {
				if (i<=stock) {
					sel_qty.append($("<option>").attr("value", i).text(i));
				}
			}
			$('.prod_stock').val(stock);
			$('.prod_size').val(size);
		});
	});
@stop

@section('script_plugin')
	@include('plugins.owlCarousel')
	@include('plugins.easyzoom')
	@include('plugins.qty-hollow')
	@include('plugins.cart-plugin')
@stop
