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
		        		<p class="text-center">Qty</p>
		        	</div>
		        	<div class="col-md-2 col-sm-2 hidden-xs">
		        		<p class="text-right">Price(Rp)</p>
		        	</div>
		        	<div class="col-md-2 col-sm-2 hidden-xs">
		        		<p class="text-right">Total(Rp)</p>
		        	</div>
		        	<div class="col-md-1 col-sm-1 hidden-xs">
		        		<p></p>
		        	</div>				        	
	        	</div>
	        	    	
		        @include('widgets.cartItemList', array(
					"itemListName" 			=> "Batik Andong Cap Jagung",
					"ItemListSku" 			=> "74347tgcs7", 
					"itemListQty"			=> "1",
					"itemListNormalPrice"	=> "290.000",
					"itemListDiscountPrice"	=> "245.000",
					"itemListTotalPrice"	=> "245.000",
		        ))

		        @include('widgets.cartItemList', array(
					"itemListName" 			=> "Batik Cikrak Cap Jigong",
					"ItemListSku" 			=> "a13f2tgcs2", 
					"itemListQty"			=> "1",
					"itemListNormalPrice"	=> "790.000",
					"itemListDiscountPrice"	=> "605.000",
					"itemListTotalPrice"	=> "605.000",
		        ))		        

		        @include('widgets.cartItemList', array(
					"itemListName" 			=> "Batik Polong Cap Singkong",
					"ItemListSku" 			=> "343f1tg3s0", 
					"itemListQty"			=> "1",
					"itemListNormalPrice"	=> "90.000",
					"itemListDiscountPrice"	=> NULL,
					"itemListTotalPrice"	=> "90.000",
		        ))	

		        <div class="row chart-topLine">
		        </div>
        	</div>
        </div>

        <!-- mobile -->
        <div class="row" style="background-color:black;">
			<div class="hidden-lg hidden-md hidden-sm col-xs-12" >
				</br>
				<div class="row" style="padding-top:5px; margin-bottom:0px;">
					<div class="col-xs-12">
						<h3 style="color:#FFF;" class="text-center">SubTotal(Rp)</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h2 style="color:#FFF; margin-top:0px;" class="text-center">10.000.000</h2>
					</div>
				</div>				
				</br>
				<div class="row">
					<div class="col-xs-12">
				        <button type="button" class="btn btn-lg btn-info btn-block">
				        	Update Cart
				        </button>
					</div>
				</div>
				</br>
				<div class="row">
					<div class="col-xs-12">
				        <button type="button" class="btn btn-lg btn-success btn-block">
				        	Checkout
				        </button>
					</div>
				</div>				
				</br>				
				</br>				
				</br>				
			</div>
        </div>

        <!-- normal -->
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
				<div class="row chart-footer">
					<div class="col-lg-9 col-md-9 col-sm-9">
						<h4 class="text-right">SubTotal(Rp) :</h4>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2">
						<h4 class="text-right">940.000</h4>
					</div>	
				</div>
				</br>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
				        <button style="margin-right:10px;"type="button" class="btn btn-success pull-right">
				        	Checkout
				        </button>
				        <button style="margin-right:10px;"type="button" class="btn btn-info pull-right">
				        	Update Cart
				        </button>
					</div>
					</br>					
					</br>					
				</div>
				</br>
			</div>
        </div>        
    </div>        
@stop

@section('script')

@stop
