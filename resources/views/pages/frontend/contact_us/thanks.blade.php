@extends('template.frontend.layout')
@section('content')    
	<div class="container mt-75">
		<div class="row">
			<div class="col-md-7 col-sm-7 col-xs-12">
				@include('widgets.breadcrumb')
			</div>
		</div>
		<div class="row">
			<div class="container">
				<div class="col-md-6 col-md-offset-3 panel text-center">
					<div class="row">
						<div class="col-md-12">
							<h3>Terima Kasih</h3>
						</div>
					</div>
					<div class="row clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12">
							<p>
								Pesan anda telah kami terima. </br> Customer Service kami akan segera membalas pesan Anda. 
							</p>
						</div>
					</div>
					<div class="row clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12">
							<a href="{{ URL::route('frontend.home.index')}}" type="submit" class="btn-hollow hollow-black-border " tabindex="1">Home</a>
						</div>
					</div>
					<div class="row clearfix">&nbsp;</div>
				</div>
			</div>
		</div>
	</div>
@stop