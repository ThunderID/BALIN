@extends('template.frontend.layout')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="m-t-md">Profile</h2>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>    
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-md-2 col-lg-2 col-sm-3 hidden-xs">              		
						@include('widgets.frontend.profile.myProfileMenu')
					</div>
					<div class="col-md-10 col-lg-10 col-sm-9">
						<div class="row">
							<div class="col-md-12">
								@if($subPage)
									@include('widgets.alerts')
									@include('widgets.frontend.profile.'. $subPage)
								@endif
							</div>
						</div>	
				   </div>
				</div>
			</div>
		</div>
	</div>
@stop