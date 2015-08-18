@extends('template.frontend.layout')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                @include('widgets.pageElements.pageTitle', array('pageTitle' => 'Shopping Cart'))
            </div>       	
        </div>
	    </br>

        <div class="row">
			<div class="col-md-12">
				<div class="row chart-header">
		        	<div class="col-md-6 col-sm-6 hidden-xs">
		        		<p>Product</p>
		        	</div>
		        	<div class="col-md-1 col-sm-1 hidden-xs">
		        		<p>Qty</p>
		        	</div>
		        	<div class="col-md-2 col-sm-2 hidden-xs">
		        		<p>Price</p>
		        	</div>
		        	<div class="col-md-2 col-sm-2 hidden-xs">
		        		<p>Total</p>
		        	</div>
		        	<div class="col-md-1 col-sm-1 hidden-xs">
		        		<p></p>
		        	</div>				        	
	        	</div>
	        	    	
		        @include('widgets.cartItemList')
		        @include('widgets.cartItemList')
		        @include('widgets.cartItemList')
		        @include('widgets.cartItemList')
        	</div>
        </div>

@stop

@section('script')

@stop