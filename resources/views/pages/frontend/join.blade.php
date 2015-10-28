@extends('template.frontend.layout')

@section('content')
	<div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-5 col-xs-12">
		                @include('widgets.pageelements.pagetitle', array('pagetitle' => 'Sign In'))                                                                                                              

                        <div class="row carousel-holder">
		                </div>

		                @include('widgets.alerts')

		                <div class="row">
		                	<div class="col-md-12">
		                		@include('widgets.login')
			                </div>
		                </div>
                    </div>

                    <div class="col-md-2"></div>

                    <div class="col-md-5 col-xs-12">
		                @include('widgets.pageelements.pagetitle', array('pagetitle' => 'Sign Up'))                                                                                                              


                        <div class="row carousel-holder">
		                </div>

		                @include('widgets.alerts')

		                <div class="row">
		                	<div class="col-md-12">
	                			@include('widgets.signup')
							</div>		                	
		                </div>                        
                    </div>

                </div>
            </div>
        </div>

	</div>
@stop