@inject('data', 'App\Models\Product')
<?php 
    $data          = $data->find($id)
?>

@extends('template.frontend.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('widgets.pageelements.pagetitle', array('pagetitle' => 'Product Details'))                                                                                                              
            </div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="row">
        			<div class="col-md-3">
			            </br>
        				<div class="row">
        					<div class="col-md-12 hidden-xs">
							    <div class="thumbnail">
							        <img class="img img-responsive myCanvas"  src="{{$data['default_image']}}" alt="">
							    </div>
						    </div>
        				</div>
        				<div class="row">
        					<div class="col-md-12">
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
    					<div class="col-xs-12 col-md-12 col-sm-12">
	        				<div class="row">
	        					<h3>{{$data['name']}}</h3>
	        					<p>
				        			<i class = "fa fa-tags"></i>
									@foreach($data->categories as $key => $value)
										@if($key!=0)
											,
										@endif
										{!! $value->name !!}
									@endforeach
				        		</p>
		        				</br>
		        				<?php $discount = $data->discount; ?> 
		        				@if($discount == 0)
			        				<h4>Price : @money_indo($data->price) </h4>
		        				@else
			        				<h4>Price : @money_indo($data->price) </h4>
			        				<h4>Promo Price: @money_indo($data->promo_price) </h4>
			        				<p>Discount : @money_indo($data->discount) </p>
		        				@endif
		        			</div>
	        				<div class="row">
		        				<h4>Deskripsi</h4>
		        				<p>{{$data->description}}</p>     
	        				</div> 					        				
        				</div>
        			</div>        			
        			<div class="col-md-1 col-sm-12 col-xs-12"></br></div>
        			<div class="col-md-3 col-sm-12 col-xs-12">
    					<div class="row panel-hollow panel-default">
        					<div class="col-md-12 col-sm-12 col-xs-12" style="padding:7px;">
								<form role="form" style="padding-right:inherit;padding-left:inherit;">
			    					@if($data->stock == 0)
				        				<div class="row">
				        					<div class="col-md-12">
						        				</br>
						        				</br>
				        						<h4 class="text-center">
			        								Sorry,</br>
			        								Out of Stock
			        							</h4>
						        				</br>
						        				</br>
				        					</div>
					        			</div>
			        				@else
				        				<div class="row">
				        					<div class="col-md-12">
				        						<h4>Beli</h4>
				        					</div>
				        				</div>
				        				<div class="row">
									      	<div class="modal-body">
											    <div class="form-group">
											        <label for="name">Qty</label>
											        <input type="number" class="form-control" max="10" id="name" tabindex="1" required>
											    </div>	
										    </div>	
				        				</div>
				        				<div class="row">
				        					<div class="col-md-12">
				        						<a href="#" class="btn-hollow hollow-black">
				        							Beli Sekarang
				        						</a>
				        					</div>
				        				</div>
					        			</br>
			        				@endif
		        				</form>
        					</div>
    					</div>
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
