@extends('template.frontend.layout')

@section('content')    
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Why Join</h3>
                    </div>
                </div>

                <div class="row carousel-holder">
                </div>

                @include('widgets.descriptionWithImageRight')  

                <div class="row carousel-holder">
                </div>

                @include('widgets.descriptionWithImageLeft') 

                <div class="row carousel-holder">
                </div>

                @include('widgets.descriptionWithImageRight')     

                <div class="row carousel-holder">
                </div>   
                <div class="row carousel-holder">
                </div>                           

                <div class="row">
                    <div class="col-md-4"></div>

                    <div class="col-md-4 text-center">
                        <H2 class="text-center">What are you waiting for?</H2>
                        <a class="btn btn-default btn-lg btn-block" href="{{ URL::route('join') }}">JOIN NOW</a>
                    </div>

                    <div class="col-md-4"></div>
                </div>

                <div class="row carousel-holder">
                </div>  
            </div>
        </div>

    </div>
@stop