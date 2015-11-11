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
							<a href="/Balin/web/balin/14-large.jpg">
								<img class="img img-responsive myCanvas"  src="/Balin/web/balin/14.jpg" style="width:100%">
							</a>
						</div>
					 </div>
				</div>
				<div class="row">
					<div class="col-md-7 col-md-offset-3">
						<div class="owl-carousel gallery-product">
							@for ($i = 0; $i < 7; $i++)
								<div class="item">
									<img class="img img-responsive canvasSource" id="canvasSource{{$i}}" src="{{$data['default_image']}}" alt="">
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
						<?php $discount = $data['discount']; ?> 
						@if ($discount == 0)
							<h4>Price : @money_indo($data['price']) </h4>
						@else
							<h4>
								Price : 
								<span style="text-decoration:line-through; color: #999">
									@money_indo($data['price'])
								</span> &nbsp;
								@money_indo($data['promo_price'])
							</h4>
							<p>Discount : @money_indo($data['discount']) </p>
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
												<div class="col-md-8">
													<select name="product_qty" class="form-control hollow">
														@for($x=1; $x<=10; $x++)
															@if ($x<=$data['stock'])
																<option value="{{ $x }}">{{ $x }}</option>
															@endif
														@endfor
													</select>
												</div>
												<div class="col-md-4" style="padding-left:0">
													{!! Form::submit('Add to Cart', ['class' => 'btn-hollow hollow-black']) !!}
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
			  var image = $(this).attr('src');
			  $('img.myCanvas').attr('src', image);
		 });    
		});  
@stop

@section('script_plugin')
	@include('plugins.owlCarousel')
	@include('plugins.easyzoom')
@stop
