@inject('product', 'App\Models\Product')
<?php 
	$data          = $product->slug($slug)->sellable(true)->with('varians')->first();
	$related 		= $product->notid($data['id'])->sellable(true)->take(4)->get();
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
						<?php $price 	= $data['price'];?>
						@if($data['discount']!=0)
							<h4><strike> @money_indo($data['price']) </strike></h4>
							<?php $price 	= $data['promo_price'];?>
						@endif
						@if($balance - $price >= 0)
							<h4><strike> @money_indo($price) </strike></h4>
							<?php $price 	= 0;?>
						@elseif($balance!=0)
							<h4><strike> @money_indo($price) </strike></h4>
							<?php $price 	= $price - $balance;?>
						@endif

						@if($price==$data['price'])
							<h4> @money_indo($price)</h4>
						@else
							<h4> @money_indo($price) </h4>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						{!! Form::open(['url' => route('frontend.cart.store'), 'class' => 'p-t-sm form']) !!}
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
								{!! Form::hidden('product_slug', $slug) !!}
								{!! Form::hidden('product_name', $data['name']) !!}
								{!! Form::hidden('product_price', $price) !!}
								{!! Form::hidden('product_discount', $data['discount']) !!}
								{!! Form::hidden('product_stock', 0, ['class' => 'prod_stock']) !!}
								{!! Form::hidden('product_image', $data['default_image']) !!}
								{!! Form::hidden('product_size', '', ['class' => 'prod_size']) !!}

								@include('widgets.alerts')
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Size</label>
											<select name="varian_id" class="form-control hollow select_varian" required>
												<option value="">Pilih Size</option>
												@foreach($data['varians'] as $v)
													<option value="{{ $v['id'] }}" data-stock="{{ $v['stock'] }}">{{ $v['size'] }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label for="name">Kuantitas</label>
											<div class="row">
												<div class="col-xs-12 col-sm-10 col-md-8">
													<select name="product_qty" class="form-control hollow select_qty" placholder="Pilih Kuantitas" >
														<option value="" disabled="disabled">Pilih Kuantitas</option>
													</select>
												</div>
												<div class="col-xs-12 col-sm-2 col-md-4 hidden-xs" style="">
													{!! Form::submit('Beli', ['class' => 'btn-hollow hollow-black-border']) !!}
												</div>
												<div class="col-xs-12 col-sm-2 col-md-4 hidden-sm hidden-md hidden-lg" style="">
													{!! Form::submit('Beli', ['class' => 'btn-hollow hollow-black-border m-t-sm']) !!}
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
						<p>{!! $data['description'] !!}</p>
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
@stop
