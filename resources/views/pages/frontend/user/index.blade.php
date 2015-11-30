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
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 header-info p-r-md p-l-md">
			<div class="row p-md">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h4 class="p-b-md">Referral Code <small><a href="#" class="link-white hover-gold unstyle">[?]</a></small></h4>	
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p class="text-uppercase text-right"><strong>{{ Auth::user()->referral_code }}</strong></p>
					<div class="clearfix">&nbsp;</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 header-info border-left">
			<div class="row p-md">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h4 class="p-b-md">Point Balin Anda <small><a href="#" class="link-white hover-gold unstyle">[?]</a></small></h4>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p class="text-right"><strong>@money_indo(Auth::user()->balance) </strong></p>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					<a class="link-white hover-gold unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route("frontend.user.point")}}" data-modal-title="History Point Balin Anda" data-view="modal-lg">[ History ]</a>
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
			<p class="label-info">
				Username
				<span>
					@if(Auth::user()->gender=='female')Ms. @else Mr. @endif {{ Auth::user()->name }}
				</span>
			</p>
			<p class="label-info">Email <span>{{ Auth::user()->email }}</span></p>
			<p class="label-info p-b-xxs">Tanggal lahir <span>@date_indo(Auth::user()->date_of_birth)</span></p>
			{{-- <a href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{ route('frontend.user.change.password') }}" data-modal-title="Ubah Password" class="btn-hollow hollow-black-border">Ubah Password</a> --}}
			<p class="clearfix p-b-xs hidden-xs">&nbsp;</p>
		</div>
		<div class="col-sm-6 border-left panel-right">
			<h5 class="title-info m-t-md">Keanggotaan</h5>
			<p class="label-info">
				Kuota Invite Referral <strong>{{Auth::user()->quota}} </strong>
			</p>
			<p class="label-info">
				Pemberi Referral Anda
				@if (!is_null(Auth::user()->reference))
					<strong>{{Auth::user()->reference}} </strong> 
				@else
					<strong>Tidak ada</strong>
					<small><a class="link-gold unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route('frontend.user.reference.get')}}" data-modal-title="Pemberi Referral Anda" data-view="modal-md">[ Tambahkan ]</a></small>
				@endif
			</p>
			<p class="label-info p-b-xxs">
				Referral Anda 
				<strong>{{Auth::user()->downline}} </strong> 
				<small><a class="link-gold unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route('frontend.user.downline')}}" data-modal-title="Lihat Referral Anda" data-view="modal-md">[ Lihat Daftar ]</a></small>
			</p>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row header-info m-l-none m-r-none">
		<div class="col-sm-12">
			<h4>Informasi Pengiriman & Tracking Order</h4>
		</div>
	</div>

	<div class="row content-info m-l-none m-r-none" style="padding-bottom:20px">

	</div>

	<div class="row content-info m-l-none m-r-none">
		<div class="col-sm-12">
			<?php
				$orders 	= App\Models\Transaction::userid(Auth::user()->id)->status(['wait', 'paid', 'shipping', 'delivered', 'canceled'])->with(['shipment', 'shipment.address'])->orderby('transact_at', 'desc')->paginate();
			?>

			@forelse ($orders as $k => $v)
				<div class="tracking-order @if(count($orders)-1!=$k) border-bottom @endif p-b-sm">
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
								@datetime_indo($v['transact_at'])
							</p>	
							<p class="label-info m-b-xxs ref-number">
								{{ $v['ref_number'] }}	
							</p>
							<a class="link-gold unstyle tracking-detail" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{ route('frontend.user.order.show', ['ref' => $v['ref_number']]) }}" data-modal-title="Detail Pesanan {{ $v['ref_number'] }}"><strong>[ Detail ]</strong></a>
						</div>
						<?php         
							$datetrans                          = new Carbon($v['transact_at'].' '.str_replace('-', '+' , $expired['value']));
						?>

						<div class="col-sm-6 p-l-none p-r-none">
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
								Pembayaran harus dilakukan sebelum @datetime_indo($datetrans)
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
				<p class="text-center p-b-xs">Tidak ada orderan, silahkan order.</p>
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
	@include('plugins.datepicker')
@stop