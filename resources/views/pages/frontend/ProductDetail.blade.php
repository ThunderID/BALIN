@inject('data', 'App\Models\Product')
<?php 
    $data          = $data->find($id)
?>

@extends('template.frontend.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('widgets.pageElements.pageTitle', array('pageTitle' => 'Products'))                                                                                                              
            </div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="row">
        			<div class="col-md-3">
			            </br>
        				<div class="row">
        					<div class="col-md-12">
							    <div class="thumbnail">
							        <img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
							    </div>
						    </div>
        				</div>
        				<div class="row">
        					<div class="col-md-12">
								<div class="owl-carousel">
								    <div class="item">
								        <img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
								    </div>					    
								    <div class="item">
								        <img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
								    </div>					    
								    <div class="item">
								        <img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
								    </div> 
								    <div class="item">
								        <img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
								    </div>					    
								    <div class="item">
								        <img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
								    </div>					    
								    <div class="item">
								        <img class="img img-responsive"  src="{{$data['default_image']}}" alt="">
								    </div>  			     
								</div>      
	        				</div>
        				</div>
        			</div>
        			<div class="col-md-5">
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
		        				<h4>Price : {{$data->price}}</h4>
	        				@else
		        				<h4>Price : {{$data->price}}</h4>
		        				<h4>Promo Price: {{$data->promo_price}}</h4>
		        				<p>Discount : {{$data->discount}}	</p>
	        				@endif
        				<div class="row">
        				</div>
	        				<h4>Deskripsi</h4>
	        				<p>{{$data->description}}</p>      					        				
        				</div>
        			</div>        			
        			<div class="col-md-1"></div>
        			<div class="col-md-3">
    					<div class="row panel panel-default">
        					<div class="col-md-12" style="padding:7px;">
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
									<form role="form" style="padding-right:inherit;padding-left:inherit;">
				        				<div class="row">
				        					<div class="col-md-12">
				        						<h4>Beli</h4>
				        					</div>
				        				</div>
				        				<div class="row">
									      	<div class="modal-body">
											    <div class="form-group">
											        <label for="name">Qty</label>
											        <input type="name" class="form-control" id="name" tabindex="1" required>
											    </div>	
										    </div>	
				        				</div>
				        				<div class="row">
				        					<div class="col-md-12">
				        						<a href="#" class="btn btn-md btn-default">
				        							Beli Sekarang
				        						</a>
				        					</div>
				        				</div>
					        			</br>
			        				</form>
		        				@endif
        					</div>
    					</div>
        			</div>
        		</div>
        	</div>
        </div> 
    </div>
@stop

@section('script_plugin')
	@include('plugins.owlCarousel')
@stop