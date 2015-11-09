@extends('template.frontend.layout')

@section('content')
	<div class="container mt-75">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-sm-2 col-xs-12">
						@include('widgets.frontend.profile.my_profile_menu')
					</div>
					<div class="col-sm-10 col-xs-12">
						@include('widgets.alerts')
						@yield('right_content')
					</div>
				</div>
			</div>
		</div>
	</div>
@stop