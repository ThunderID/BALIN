@inject('data', 'App\Models\Product')
<?php 
	 $data          = $data->find($id)
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container mt-75">
		<div class="row">
			<div class="col-lg-12 m-b-md">
				@include('widgets.pageelements.pagetitle', array('pagetitle' => 'Product Details'))
			</div>
		</div>
		<div class="row">
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 text-center hidden-xs hidden-sm">
						<div class="thumbnail m-t-md">
							<img class="img img-responsive myCanvas"  src="{{$data['default_image']}}" alt="">
						</div>
					 </div>
				</div>
				<div class="row">
					<div class="col-md-7 col-md-6 col-md-offset-3">
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
						<h3>{{ $data['name'] }}</h3>
						<div class="clearfix">&nbsp;</div>
						<?php $discount = $data['discount']; ?> 
						@if ($discount == 0)
							<h4>Price : @money_indo($data['price']) </h4>
						@else
							<h4>
								Price : 
								<span style="text-decoration:line-through; color: #ccc">
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
							@if (!$data)
								<div class="row">
									<div class="col-md-12 m-b-md">
										<h4 class="text-center">
											Sorry,</br>
											Out of Stock
										</h4>
									</div>
								</div>
							@else
								<div class="row">
									<div class="col-md-12">
										{!! Form::hidden('product_id', $id) !!}
										<div class="form-group">
											<label for="name">Qty</label>
											<div class="row">
												<div class="col-md-8">
													{!! Form::input('number', 'product_qty', null, ['class' => 'form-control hollow', 'max' => '10', 'min' => '0']) !!}
												</div>
												<div class="col-md-4" style="padding-left:0">
													{!! Form::submit('Add to Cart', ['class' => 'btn-hollow hollow-black']) !!}
												</div>
											</div>
										</div>	
									</div>	
								</div>
								<div class="row">
									<div class="col-md-12">
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
								{!! $value['name'] !!}
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
@stop
