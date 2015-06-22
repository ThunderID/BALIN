@extends('template.frontend.layout')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                	<div class="col-md-12">
		                <h3>Products</h3>
                	</div>
                </div>
                <div class="row">
                	<div class="col-md-2 col-sm-6 col-xs-12 pull-right">
                		<p class="pull-right">Search</p>
                	</div>                	                	
                	<div class="col-md-2 col-sm-4 col-xs-12 pull-right">
                		<p class="pull-right">Sort by</p>
                	</div>
                	<div class="col-md-1 col-sm-2 col-xs-12 pull-right">
                		<p class="pull-right">Kategori</p>
                	</div>
                </div>
                <div class="row carousel-holder">
                </div>

                <div class="row">

                	@for ($i = 0; $i < 9; $i++)
                	    <div class="col-sm-4 col-lg-4 col-md-4">
		                	@include('widgets.productCard')
		                </div>
					@endfor

                </div>

            </div>

        </div>

    </div>
@stop