@inject('product', 'App\Models\Product')
<?php 
	$related 		= $product->notid($data['id'])->sellable(true)->currentprice(true)->DefaultImage(true)->take(4)->get();
	$carts 			= Session::get('baskets');
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container m-t-sm m-b-xl">
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
							<a class="img-large" href="{{ $data['images'][0]['image_lg'] }}" >
								<img class="img img-responsive canvas-image"  src="{{ $data['images'][0]['image_md'] }}" style="width:100%">
							</a>
						</div>
					 </div>
				</div>
				<div class="row">
					<div class="col-md-7 col-md-offset-3">
						@if (count($data['images'])!=1)
							<div class="owl-carousel gallery-product">
								@foreach ($data['images'] as $k => $v)
									<div class="item">
										<a href="{{ $v['image_lg'] }}" data-standard="{{ $v['image_lg'] }}">
											<img class="img img-responsive canvasSource" id="canvasSource{{$k}}" src="{{$v['image_md']}}" alt="">
										</a>
									</div>
								@endforeach
							</div>      
						@else
							<div class="owl-carousel gallery-product hidden-xs hidden-sm">
								@foreach ($data['images'] as $k => $v)
									<div class="item">
										<a href="{{ $v['image_lg'] }}" data-standard="{{ $v['image_lg'] }}">
											<img class="img img-responsive canvasSource" id="canvasSource{{$k}}" src="{{$v['image_md']}}" alt="">
										</a>
									</div>
								@endforeach
							</div>
							<div class="row">
								<div class="col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2">
									<img class="img img-responsive canvas-image hidden-md hidden-lg"  src="{{ $data['images'][0]['image_md'] }}">
								</div>
							</div>  
						@endif
					</div>        				
				</div>
			</div>
			<div class="col-md-5 product-info">
				<div class="row">
					<div class="col-md-12">
						<h3 class="title-product caption-product">{{ $data['name'] }}</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" style="margin-bottom: 33px;">
						<!-- <a onclick="facebookShare()" href="javascript:void(0);" class="btn btn-share btn-hollow hollow-social hollow-black hollow-black-border "><i class="fa fa-facebook"></i>&nbsp;&nbsp;share</a>
						<a onclick="twitterShare()" href="javascript:void(0);" class="btn btn-share btn-hollow hollow-social hollow-black hollow-black-border "><i class="fa fa-twitter"></i>&nbsp;&nbsp;tweet</a> -->
					</div>
				</div>
				<div class="row">
					@foreach($data['lables'] as $label)
						<div class="col-md-3 col-sm-2 col-xs-3 p-b-sm">
						<?php

						switch (str_replace('_', '', strtoupper($label['lable']))) {
							case "SALE":
								// echo "<div class='circle-label black'><div>SALE</div></div>";
								echo "<div class='square-label no-background black'><div>SALE</div></div>";
								break;
							case "HOTITEM":
								// echo "<div class='circle-label black'><div><p style='margin-top: -6px;''>HOT ITEM</p></div></div>";
								echo "<div class='square-label no-background black'><div>HOT ITEM</div></div>";
								break;	
							case "BESTSELLER":
								// echo "<div class='circle-label black'><div><p style='margin-top: -6px; font-size: 12px;'>BEST SELLER</p></div></div>";
								echo "<div class='square-label no-background black'><div>BEST SELLER</div></div>";
								break;															
							default:
								// echo "<div class='circle-label black'><div><p style='margin-top: -6px; font-size: 12px;'>" . str_replace('_', ' ', strtoupper($label['lable'])) . "</p></div></div>";
								echo "<div class='square-label no-background black'><div>" . str_replace('_', ' ', strtoupper($label['lable'])) . "</div></div>";
								break;
						}

						?>
						</div>
					@endforeach									
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="clearfix">&nbsp;</div>
						{{-- <h4 class="caption-product">Price</h4> --}}
						<?php $price 	= $data['price'];?>
						@if($data['discount']!=0)
							<span class="text-product small-price">@money_indo($data['price'])</span>
							<?php $price 	= $data['promo_price'];?>
						@endif

						@if($price==$data['price'])
							<h4 class="text-product price"> @money_indo($price)</h4>
						@else
							<h4 class="text-product price"><strong>@money_indo($price)</strong></h4>
						@endif
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
				<?php $product = json_decode($data['description'], true);?>
				<div class="row">
					<div class="col-md-12">
						<h4 class="caption-product label-show">Deskripsi</h4>
						<div class="text-product">{!! $product['description'] !!}</div>
					</div> 					        				
				</div>
				<div class="clearfix"> &nbsp;</div>
				<div class="row">
					<div class="col-sm-12">
						<h4 class="caption-product label-show">Ukuran & Fit</h4>
						<div class="text-product">{!! $product['fit'] !!}</div>
					</div>
				</div>
				<div class="clearfix"> &nbsp;</div>
				<div class="row m-t-sm m-b-md">
					<div class="col-sm-12 col-md-12">
						<h4 class="caption-product label-show">Pilih Ukuran</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
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

							@include('widgets.alerts')
							<div class="row text-center">
								{!! Form::open(['url' => 'javascript:void(0);', 'class' => 'p-t-sm form-addtocart']) !!}
									{!! Form::hidden('product_slug', $slug, ['class' => 'pslug']) !!}
									{!! Form::hidden('product_name', $data['name'], ['class' => 'pname']) !!}
									{!! Form::hidden('product_price', $data['price'], ['class' => 'pprice']) !!}
									{!! Form::hidden('product_discount', $data['discount'], ['class' => 'pdiscount']) !!}
									{!! Form::hidden('product_stock', 0, ['class' => 'prod_stock pstock']) !!}
									{!! Form::hidden('product_image', $data['default_image'], ['class' => 'pimage']) !!}
									{!! Form::hidden('product_size', '', ['class' => 'prod_size psize']) !!}

									@foreach($data['varians'] as $k => $v)
										@if ($k<=2)
											<div class="col-xs-4 col-sm-4 col-md-4 text-center">
												<div class="form-group">
													<div class="qty-hollow m-b-lg">
														<label class="label-qty">
															@if (strpos($v['size'], '.')==true)
																<?php $frac = explode('.', $v['size']); ?>
																{{ $frac[0].' &frac12;'}}
															@else
																{{ $v['size'] }}
															@endif
														</label>
														<input type="hidden" name="varianids[{{$v['id']}}]" class="form-control pvarians" value="{{$v['id']}}">
														<input type="number" name="qty[{{$v['id']}}]" class="form-control hollow form-qty input-number pqty" 
														value="@if(isset($carts[$data['id']]) && $carts[$data['id']]['slug'] == $slug)@if(isset($carts[$data['id']]['varians'][$v['id']]) && ($carts[$data['id']]['varians'][$v['id']]['varian_id']  == $v['id'])){{$carts[$data['id']]['varians'][$v['id']]['qty']}}@else{{'0'}}@endif{{''}}@else{{'0'}}@endif" min="0" max="@if(50<=$v['stock']){{'50'}}@else{{ $v['stock'] }}@endif" 
														data-stock="{{ $v['stock'] }}" 
														data-id="{{ $v['id'] }}" 
														data-price="{{ $data['price'] }}"
														data-discount="{{ $data['discount'] }}"
														data-total="@if(isset($carts[$data['id']]) && $carts[$data['id']]['slug'] == $slug)@if(isset($carts[$data['id']]['varians'][$v['id']]) && ($carts[$data['id']]['varians'][$v['id']]['varian_id']  == $v['id'])){{($carts[$data['id']]['price']-$carts[$data['id']]['discount'])*$carts[$data['id']]['varians'][$v['id']]['qty']}}@else{{'0'}}@endif{{''}}@else{{'0'}}@endif"
														data-name="qty-{{strtolower($v['size'])}}[1]" 
														data-oldValue="" 
														data-toggle="tooltip" 
														data-placement="right" 
														@if($v['stock']==0){{'disabled'}}@endif>

														<button type="button" class="btn-hollow btn-hollow-sm btn-qty qty-minus btn-number" disabled="disabled" 
														data-type="minus" data-field="qty-{{strtolower($v['size'])}}[1]">
															<i class="fa fa-minus"></i>
														</button>
														<button type="button" class="btn-hollow btn-hollow-sm btn-qty qty-plus btn-number" data-type="plus" 
														data-field="qty-{{strtolower($v['size'])}}[1]" @if($v['stock']==0){{'disabled="disabled"'}}@endif>
															<i class="fa fa-plus"></i>
														</button>
													</div>
												</div>
											</div>
										@endif
									@endforeach
								{!! Form::close() !!}
							</div>
							<div class="row m-t-xl">
								<div class="col-sm-12">
									<div class="qty-total">
										<h4 class="pull-left m-t-sm caption-product">
											Total
										</h4>
										<?php $price 	= $data['price'];?>
										@if($data['discount']!=0)
											<?php $price 	= $data['promo_price'];?>
										@endif
										<?php $total = 0;?>
										@if (!empty($carts))
											@foreach ($carts as $k => $item)
												<?php
													$qty 			= 0;
													foreach ($item['varians'] as $key => $value) 
													{
														$qty 		= $qty + $value['qty'];
													}
													$total += (($item['price']-$item['discount'])*$qty); 
												?>
											@endforeach
											<label class="text-right m-t-xs text-product price-all-product" data-price="{{ $price }}"> @money_indo($total)</label> 
										@else
											<label class="text-right m-t-xs text-product price-all-product" data-price="{{ $price }}"> @money_indo('0')</label> 
										@endif
									</div>
								</div>
							</div>
							<div class="row m-t-sm">
								<div class="col-sm-4 col-xs-4">
									
								</div>
								<div class="col-sm-8 col-xs-8">
									<div class="form-group text-right">
										<a href="javascript:void(0);" class="btn-hollow hollow-black-border addto-cart">ADD TO CART</a>
									</div>	
								</div>	
							</div>
							<div class="clearfix">&nbsp;</div>
						@endif
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
		@if(isset($related[0]))
			<div class="row m-t-lg m-b-md related-product">
				<div class="col-sm-12">
					<h4 class="text-uppercase">Produk Lainnya</h4>
				</div>
			</div>
			<div class="row">
				@foreach($related as $data)
					<div class="col-xs-6 col-sm-6 col-md-3">
						@include('widgets.product_card')
					</div>
				@endforeach
			</div>
		@endif
	</div>

	<div id="fb-root"></div>
	
	@stop

@section('script')
	function facebookShare() {
		var myWindow = window.open("http://www.facebook.com/sharer/sharer.php?u={{ route('frontend.product.show', $data['slug']) }}#&title={{$data['name']}}", "Balin", "width=600", "height=580", "top=10", "left=10");
	};
	function twitterShare() {
		var myWindow = window.open("http://www.twitter.com/share?url={{ route('frontend.product.show', $data['slug']) }}#&title={{$data['name']}}", "Balin", "width=600", "height=580", "top=10", "left=10");
	};
	$(document).ready(function() {
		//$('.myCanvas').change(function() {
		//	  alert()
		 //});

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
	@include('plugins.cart-plugin')
	@include('plugins.notif', ['data' => ['title' => 'Terima Kasih', 'content' => 'Produk telah ditambahkan di cart']])
@stop
