@inject('setting', 'App\Models\StoreSetting')
<?php 
	$status 	= ['abandoned' => 'Terabaikan', 'cart' => 'Keranjang', 'wait' => 'Checkout', 'paid' => 'Pembayaran Diterima', 'shipping' => 'Dalam Pengiriman', 'delivered' => 'Pesanan Complete', 'canceled' => 'Pesanan Dibatalkan'];
	$expired 		= $setting::type('expired_paid')->ondate('now')->first();
?>

@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-md-8 col-sm-10 col-xs-12">
			<p class="m-t-md user-hello">
				<strong>Halo, @if(Auth::user()->gender=='female')Ms. @else Mr. @endif {{Auth::user()->name}}!</strong>
			</p>
		</div>
		<div class="col-md-4 col-sm-2 hidden-xs">
			<p class="m-t-md user-hello">
				<span class="">
					<a href="{{ route('frontend.dologout') }}" class="link-black hover-gray unstyle"><strong><i class="fa fa-sign-out"></i> Logout</strong></a>
				</span>
			</p>
		</div>
		<div class="hidden-lg hidden-sm hidden-md col-xs-12 m-t-none">
			<p class="user-hello" style="margin-top:-10px;">
				<span class="">
					<a href="{{ route('frontend.dologout') }}" class="link-black hover-gray unstyle"><strong><i class="fa fa-sign-out"></i> Logout</strong></a>
				</span>
			</p>
		</div>		
	</div>
	<div class="row">
		<div class="col-md-12">
			<p class="m-t-md">
			Melalui halaman profile anda, anda dapat melihat aktivitas akun anda dan mengubah informasi akun. Klik link yang tersedia untuk melihat atau mengubah profil anda.
			</p>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>

	<div class="row point-info m-l-none m-r-none">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 header-info p-r-md p-l-md">
			<div class="row p-md">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-r-none">
					<h4 class="p-b-md text-left">Referral Code 
						<small>
							<a href="#" class="link-white hover-gold unstyle help" data-toggle="modal" data-target=".referral-user-information">&nbsp;[?]</a>
						</small>
					</h4>	
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p class="text-uppercase text-right hidden-xs"><strong>{{ Auth::user()->referral_code }}</strong></p>
					<p class="text-uppercase text-left hidden-sm hidden-md hidden-lg"><strong>{{ Auth::user()->referral_code }}</strong></p>
					<div class="clearfix hidden-xs">&nbsp;</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 header-info p-r-md p-l-md panel-right border-left">
			<div class="row p-md">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
					<h4 class="p-b-md">Point Balin Anda 
						<small>
							<a href="#" class="link-white hover-gold unstyle help" data-toggle="modal" data-target=".point-user-information">&nbsp;[?]</a>
						</small>
					</h4>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p class="text-right hidden-xs"><strong>@money_indo(Auth::user()->balance) </strong></p>
					<p class="text-left hidden-sm hidden-md hidden-lg"><strong>@money_indo(Auth::user()->balance) </strong></p>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a class="link-white hover-gold unstyle text-right hidden-xs" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route("frontend.user.point")}}" data-modal-title="History Point Balin Anda" data-view="modal-lg">[ History ]</a>
					<a class="link-white hover-gold unstyle text-left hidden-sm hidden-md hidden-lg" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route("frontend.user.point")}}" data-modal-title="History Point Balin Anda" data-view="modal-lg">[ History ]</a>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row header-info m-l-none m-r-none">
		<div class="col-sm-12">
			<h4>Informasi Akun</h4>
		</div>
	</div>
	<div class="row content-info m-l-none m-r-none">
		<div class="col-sm-6">
			<h5 class="title-info m-t-md">
				Informasi Umum 
				<small>
					<a class="link-gold unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{ route('frontend.user.edit') }}" data-modal-title="Ubah Informasi User" data-view="modal-lg" class="balin-link">
						<i class="fa fa-pencil"></i> Ubah
					</a>
				</small>
			</h5>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					Username
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<p class="text-right hidden-xs hidden-sm">
						<strong>@if(Auth::user()->gender=='female')Ms. @else Mr. @endif {{ Auth::user()->name }}</strong>
					</p>
					<p class="text-left hidden-md hidden-lg">
						<strong>@if(Auth::user()->gender=='female')Ms. @else Mr. @endif {{ Auth::user()->name }}</strong>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					Email
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<p class="text-right hidden-xs hidden-sm">
						<strong>{{ Auth::user()->email }}</strong>
					</p>
					<p class="text-left hidden-md hidden-lg">
						<strong>{{ Auth::user()->email }}</strong>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					Tanggal lahir
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<?php 
						$date_default = \Carbon::createFromFormat('Y-m-d', '0000-00-00')->format('d-m-Y');
						$date_bod = Auth::user()->date_of_birth->format('d-m-Y');
					?>
					<p class="text-right hidden-xs hidden-sm">
						@if ($date_bod!=$date_default)
							<strong>@date_indo(Auth::user()->date_of_birth)</strong>
						@endif
					</p>
					<p class="text-left hidden-md hidden-lg">
						@if ($date_bod!=$date_default)
							<strong>@date_indo(Auth::user()->date_of_birth)</strong>
						@endif
					</p>
				</div>
			</div>
		</div>
		<div class="col-sm-6 border-left panel-right">
			<h5 class="title-info m-t-md">Keanggotaan</h5>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					Kuota Invite Referral
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<p class="text-right hidden-xs hidden-sm">
						<strong>{{ Auth::user()->quota }}</strong>
					</p>
					<p class="text-left hidden-md hidden-lg">
						<strong>{{ Auth::user()->quota }}</strong>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					Pemberi Referral Anda
					@if (is_null(Auth::user()->reference))
						<small>
							<a class="link-gold unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route('frontend.user.reference.get')}}" data-modal-title="Pemberi Referral Anda" data-view="modal-md">[ Tambahkan ]</a>
						</small>
					@endif
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<p class="text-right hidden-xs hidden-sm">
						@if (!is_null(Auth::user()->reference))
							<strong>{{ Auth::user()->reference }}</strong>
						@else
							<strong>Tidak ada</strong>
						@endif
					</p>
					<p class="text-left hidden-md hidden-lg">
						@if (!is_null(Auth::user()->reference))
							<strong>{{ Auth::user()->reference }}</strong>
						@else
							<strong>Tidak ada</strong>
						@endif
					</p>
				</div>
			</div>
			<div class="row p-b-xs">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
					Referral Anda 
					<small>
						<a class="link-gold unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route('frontend.user.downline')}}" data-modal-title="Lihat Referral Anda" data-view="modal-md">
							[ Lihat Daftar ]
						</a>
					</small>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<p class="text-right hidden-xs hidden-sm">
						<strong>{{Auth::user()->downline}} </strong> 
					</p>
					<p class="text-left hidden-md hidden-lg">
						<strong>{{Auth::user()->downline}} </strong> 						
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row header-info m-l-none m-r-none">
		<div class="col-sm-12">
			<h4>Informasi Pengiriman & Tracking Order</h4>
		</div>
	</div>
	<div class="row content-info m-l-none m-r-none">
		<div class="col-sm-12">
			<?php
				$orders 	= App\Models\Transaction::userid(Auth::user()->id)->status(['wait', 'paid', 'packed', 'shipping', 'delivered', 'canceled'])->with(['shipment', 'shipment.address'])->orderby('transact_at', 'desc')->paginate();
			?>

			@forelse ($orders as $k => $v)
				<div class="tracking-order @if(count($orders)-1!=$k) border-bottom @endif @if($k==0) p-t-md @endif p-b-sm">
					<div class="row m-l-none m-r-none">
						<div class="col-sm-6 p-l-none p-r-none">
							<span class="label 
								@if ($v['current_status']=='wait') label-default 
								@elseif ($v['current_status']=='paid') label-info
								@elseif ($v['current_status']=='shipping') label-primary
								@elseif ($v['current_status']=='delivered') label-success
								@else label-warning @endif
							label-hollow">
								{{ $status[$v['current_status']] }}
							</span>
							<p class="label-info datetime m-t-xs m-b-xxs" style="">
								@datetime_with_name_month_indo($v['transact_at'])
							</p>	
							<p class="label-info m-b-xxs ref-number">
								{{ $v['ref_number'] }}	
							</p>
							<a class="link-gold unstyle tracking-detail" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{ route('frontend.user.order.show', ['ref' => $v['ref_number']]) }}" data-modal-title="Detail Pesanan {{ $v['ref_number'] }}"><strong>[ Detail ]</strong></a>
						</div>
						<?php         
							$datetrans                          = new Carbon($v['transact_at'].' '.str_replace('-', '+' , $expired['value']));
						?>

						<div class="col-sm-6 p-t-sm p-l-none p-r-none">
							@if($v['status']=='wait')
								<span class="tracking-cancel">
								    <a class="link-grey hover-red unstyle link-cancel-tracking" href="#" data-toggle="modal" 
								    data-target=".modal-user-information" data-action="{{ route('frontend.user.order.confirm') }}" data-action-parsing="{{ route('frontend.user.order.destroy', ['ref' => $v['ref_number']])  }}" data-modal-title="Pembatalan Pesanan">
								    	[ Batal ]
								    </a>
								</span>
							@endif
							<span>
								Dikirim Ke
							</span>
							<p class="label-info m-b-xxs">
								{{$v['shipment']['address']['address']}}, {{$v['shipment']['address']['zipcode']}}
							</p>
							<p class="label-info m-b-xxs">
								a.n. {{$v['shipment']['receiver_name']}}
							</p>
							@if($v['current_status']=='wait')
							<p class="label-info datetime" style="">
								<small>
								Pembayaran harus dilakukan sebelum @datetime_with_name_month_indo($datetrans)
								</small>
							</p>
							@endif
						</div>
					</div>
				</div>
				@if(count($orders)-1!=$k)
				<div class="clearfix">&nbsp;</div>
				@endif
			@empty
				<p class="text-center p-t-sm p-b-xxs">Tidak ada data.</p>
			@endforelse
		</div>
	</div>


	<!-- Modal Balance -->
	<div id="modal-balance" class="modal modal-user-information modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
		       		<h5 class="modal-title" id="exampleModalLabel">History Balance</h5>
		      	</div>
		      	<div class="modal-body mt-75 mobile-m-t-0" style="text-align:left">
					
		      	</div>
	   		</div>
	  	</div>
	</div>
	<!-- Modal Balance -->
	<div id="submodal-balance" class="modal submodal-user-information modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
		       		<h5 class="modal-title" id="exampleModalLabel">History Balance</h5>
		      	</div>
		      	<div class="modal-body mt-75 mobile-m-t-0" style="text-align:left">
					
		      	</div>
	   		</div>
	  	</div>
	</div>

	<!-- Modal Info Point -->
	<div id="" class="modal point-user-information modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
		       		<h5 class="modal-title" id="exampleModalLabel">Point</h5>
		      	</div>
		      	<div class="modal-body mt-75 mobile-m-t-10" style="text-align:left">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		      	</div>
	   		</div>
	  	</div>
	</div>

	<!-- Modal Info Referral Code -->
	<div id="" class="modal referral-user-information modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
		       		<h5 class="modal-title" id="exampleModalLabel">Referral Code</h5>
		      	</div>
		      	<div class="modal-body mt-75 mobile-m-t-10" style="text-align:left">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		      	</div>
	   		</div>
	  	</div>
	</div>
@stop

@section('script')
	@if(Input::has('ref'))
	var event = new Event('build');
	var actions 	= "{!! route('frontend.any.checked.out', ['ref' => Input::get('ref')]) !!}";
	// Listen for the event.
	document.addEventListener('build', function (e) 
	{
		var action = actions;
		var title = "Pesanan Disimpan";
		var view_mode = '';
		parsing = '';

		$('#modal-balance').find('.modal-body').html('loading...');
		$('#modal-balance').find('.modal-title').html(title);
		$('#modal-balance').find('.modal-dialog').addClass(view_mode);
		$('#modal-balance').find('.modal-body').load(action, function() {
			if (parsing !== null && parsing !== undefined) {
				change_action($(this), parsing);
			}
		});

		$('#modal-balance').modal('show');
	}, false);

	// Dispatch the event.
	document.dispatchEvent(event);

	$('#modal-balance').on('hidden.bs.modal', function () {
		window.history.pushState('obj', 'newtitle', '/profile');
		return false;
	})

	@endif

	var view_mode = '';
	var parsing = '';

	$('.modal-user-information').on('show.bs.modal', function(e) {
		var action = $(e.relatedTarget).attr('data-action');
		var title = $(e.relatedTarget).attr('data-modal-title');
		var view_mode = $(e.relatedTarget).attr('data-view');
		parsing = $(e.relatedTarget).attr('data-action-parsing');

		$(this).find('.modal-body').html('loading...');
		$(this).find('.modal-title').html(title);
		$(this).find('.modal-dialog').addClass(view_mode);
		$(this).find('.modal-body').load(action, function() {
			if (parsing !== null && parsing !== undefined) {
				change_action($(this), parsing);
			}
		});
	});

	$('.submodal-user-information').on('show.bs.modal', function(e) {
		var action = $(e.relatedTarget).attr('data-action');
		var title = $(e.relatedTarget).attr('data-modal-title');
		var view_mode = $(e.relatedTarget).attr('data-view');
		parsing = $(e.relatedTarget).attr('data-action-parsing');

		$(this).find('.modal-body').html('loading...');
		$(this).find('.modal-title').html(title);
		$(this).find('.modal-dialog').addClass(view_mode);
		$(this).find('.modal-body').load(action, function() {
			if (parsing !== null && parsing !== undefined) {
				change_action($(this), parsing);
			}
		});
	});

	$('.modal-balance').on('hidden.bs.modal', function(e) {
		$('.modal-dialog').removeClass(view_mode);
		$(this).find('.modal-body').removeData('bs.modal');
	});

	$(".modal-fullscreen").on('show.bs.modal', function () {
	  	setTimeout( function() {
	    	$(".modal-backdrop").addClass("modal-backdrop-fullscreen");
	  	}, 0);
	});
	$(".modal-fullscreen").on('hidden.bs.modal', function () {
		$(".modal-backdrop").addClass("modal-backdrop-fullscreen");
	});

	// After load event
	function change_action(e) {
		e.context.firstChild.action = parsing;
	}

	$(window).resize(function() {
		wd = $(this).width();

		if (wd < 750) {
			$('.panel-right').removeClass('border-left');
			$('.panel-right').addClass('border-top');
		}
		else {
			$('.panel-right').removeClass('border-top');
			$('.panel-right').addClass('border-left');
		}
	});

	$(window).load(function() {
		wd = $(this).width();

		if (wd < 750) {
			$('.panel-right').removeClass('border-left');
			$('.panel-right').addClass('border-top');
		}
		else {
			$('.panel-right').removeClass('border-top');
			$('.panel-right').addClass('border-left');
		}
	});
@stop

@section('script_plugin')
	@include('plugins.input-mask')
@stop