@extends('template.frontend.layout')

@section('content')
	<div class="container m-t-sm mb-100">
		<div class="row">
			<div class="col-lg-12">
				@include('widgets.breadcrumb')
			</div>
		</div>
		<div class="row">
			{{-- <div class="col-sm-2 col-xs-12"> --}}
				{{-- @include('widgets.frontend.profile.my_profile_menu') --}}
			{{-- </div> --}}
			<div class="col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-sm-12">
						@include('widgets.alerts')
					</div>
				</div>
				<div class="row user-page">
					<div class="col-sm-12">
						@yield('right_content')
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
@stop