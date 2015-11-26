@extends('template.frontend.layout')
@section('content')    
	<div class="container mobile-m-t-10">
		<div class="row">
			<div class="col-md-7 col-sm-7 col-xs-12">
				@include('widgets.breadcrumb')
			</div>
		</div>
		<div class="row">
			<div class="container">
				<div class="col-md-6 colsm-6 col-xs-12  panel">
					<div class="row">
						<div class="col-md-12">
							<h3>Contact Us</h3>

							@include('widgets.backend.pageelements.alertbox')

							{!! Form::open(['url' => route('contactus.dosubmit')]) !!}
							    <div class="form-group">
							        <label for="name" style="font-weight:400">Nama *</label>
									{!! Form::text('name', (Auth::check() ? Auth::user()->name : ''), [
												'class'         => 'form-control hollow', 
												'tabindex'      => '1', 
												'placeholder'   => 'Masukkan nama anda',
												'required' 		=> 'required'
									]) !!}
							    </div>
							    <div class="form-group">
							        <label for="email" style="font-weight:400">Email *</label>
									{!! Form::email('email', (Auth::check() ? Auth::user()->email : ''), [
												'class'         => 'form-control hollow', 
												'tabindex'      => '2', 
												'placeholder'   => 'Masukkan email anda',
												'required' 		=> 'required'
									]) !!}
							    </div>

							    <div class="form-group">
								    <label for="message" style="font-weight:400">Pesan *</label>
									{!! Form::textarea('message',null, [
												'class'         => 'form-control hollow', 
												'placeholder'   => 'Masukkan pesan anda',
												'rows'          => '5',
												'tabindex'      => '3',
												'style'         => 'resize:none;',
												'required' 		=> 'required'
									]) !!}
								</div>
								<p class="t-xs" style="color:#666">
									* wajib untuk diisi.
								</p>
								<div class="clearfix">&nbsp;</div>
								<div class="form-group">
								    <button type="submit" class="btn-hollow hollow-black-border " tabindex="4">Kirim</button>
								</div>
								<div class="clearfix">&nbsp;</div>
							{!! Form::close() !!}							
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 hide-xs">
					<div class="row">
						<div class="col-md-12 text-center">					
							<h3>We'd love to help!</h3>
						</div>
					</div>
					<div class="row clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12 text-center">						
							<p><i class="fa fa-map-marker"></i> &nbsp;{{ $storeinfo['address'] }}</p>
						</div>						
					</div>		
					<div class="row">
						<div class="col-md-12 text-center">						
							<p><i class="fa fa-phone"></i> &nbsp;{{ $storeinfo['phone'] }}</p>
						</div>						
					</div>	
					<div class="row">
						<div class="col-md-12 text-center">						
							<p><i class="fa fa-envelope"></i> &nbsp;{{ $storeinfo['email'] }}</p>
						</div>						
					</div>														
					<div class="row clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12 text-center">					
							<h3>Also find us on</h3>
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<a href="{{ $storeinfo['instagram_url'] }}" target="blank" class="btn btn-hollow hollow-social hollow-black hollow-black-border "><i class="fa fa-instagram fa-2x"></i></a>
							<a href="{{ $storeinfo['twitter_url'] }}" target="blank" class="btn btn-hollow hollow-social hollow-black hollow-black-border "><i class="fa fa-twitter fa-2x"></i></a>
							<a href="{{ $storeinfo['facebook_url'] }}" target="blank" class="btn btn-hollow hollow-social hollow-black hollow-black-border "><i class="fa fa-facebook fa-2x"></i></a>
						</div>
					</div>
				</div>
<!-- 				<div class="col-md-6 col-sm-6 hide-xs">
					<div class="row">
						<div class="col-md-12 text-center">
							<h3>Also find us on</h3>					
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<a href="#" class="btn btn-hollow hollow-social hollow-black hollow-black-border "><i class="fa fa-facebook"></i>&nbsp;&nbsp;Facebook</a>
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<p style="margin-bottom:0px;">or</p>					
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<a href="#" class="btn btn-hollow hollow-social hollow-black hollow-black-border "><i class="fa fa-twitter"></i>&nbsp;&nbsp;Twitter</a>
						</div>
					</div>					
				</div> -->
			</div>
 		</div>
	</div>
	<!-- Modal Balance -->
	<div id="modal-balance" class="modal modal-user-information modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		       		<h5 class="modal-title" id="exampleModalLabel">Terima Kasih</h5>
		      	</div>
		      	<div class="modal-body mt-75 mobile-m-t-0" style="text-align:center">
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
		      	</div>
	   		</div>
	  	</div>
	</div>
	<!-- Modal Balance -->
	<div id="submodal-balance" class="modal submodal-user-information modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		       		<h5 class="modal-title" id="exampleModalLabel">Terima Kasih</h5>
		      	</div>
		      	<div class="modal-body mt-75 mobile-m-t-0" style="text-align:center">
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
 		      	</div>
	   		</div>
	  	</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop

@section('script')
	@if(Input::has('success'))
	var event = new Event('build');
	// Listen for the event.
	document.addEventListener('build', function (e) 
	{
		$('#modal-balance').modal('show');
	}, false);

	// Dispatch the event.
	document.dispatchEvent(event);
	@endif
@stop
