@extends('template.frontend.layout')

@section('content')
	<div class="container">
		<div class="row mt-75">
			<div class="col-lg-12">
				<h2>Profile</h2>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>    
		<div class="row">
			<div class="col-md-2 col-lg-2 col-sm-3 hidden-xs">              		
				@include('widgets.frontend.profile.my_profile_menu')
			</div>
			<div class="col-md-10 col-lg-10 col-sm-9">
				<div class="row">
					<div class="col-md-12">
						@if ($sub_page)
							@include('widgets.alerts')
							@include('widgets.frontend.profile.'. $sub_page)
						@endif
					</div>
				</div>	
			</div>
		</div>
	</div>
@stop