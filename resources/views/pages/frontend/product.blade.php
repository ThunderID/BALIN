@extends('template.frontend.layout')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="row carousel-holder">
                </div>

                <div class="row">

                	@for ($i = 0; $i < 9; $i++)
	                	@include('widgets.productCard')
					@endfor

                </div>

            </div>

        </div>

    </div>
@stop