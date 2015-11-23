@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-sm-12">
			<p class="m-t-md user-hello">
				<strong>Halo, @if(Auth::user()->gender=='female')Ms. @else Mr. @endif {{Auth::user()->name}}!</strong>
				<span class="">
					<a href="{{ route('frontend.dologout') }}" class="link-black hover-gray unstyle"><strong><i class="fa fa-sign-out"></i> Logout</strong></a>
				</span>
			</p>
			<p class="m-t-md">
			Melalui halaman profile anda, anda dapat melihat aktivitas akun anda dan mengubah informasi akun. Klik link yang tersedia untuk melihat atau mengubah profil anda.
			</p>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row header-info m-l-none m-r-none">
		<div class="col-sm-12">
			<h4>Informasi Akun</h4>
		</div>
	</div>
	<div class="row content-info m-l-none m-r-none">
		<div class="col-sm-6 border-right">
			<h5 class="title-info m-t-md">
				Informasi Umum 
				<small>
					<a class="link-grey hover-black unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{ route('frontend.user.edit') }}" data-modal-title="Ubah Informasi User" data-view="modal-lg" class="balin-link">
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
			<p class="label-info">Tanggal lahir <span>@date_indo(Auth::user()->date_of_birth)</span></p>
			{{-- <a href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{ route('frontend.user.change.password') }}" data-modal-title="Ubah Password" class="btn-hollow hollow-black-border">Ubah Password</a> --}}
			<p class="clearfix p-b-xs">&nbsp;</p>
			<p class="clearfix p-b-xs">&nbsp;</p>
		</div>
		<div class="col-sm-6">
			<h5 class="title-info m-t-md">Keanggotaan</h5>
			<p class="label-info">
				Pointku <strong> @money_indo(Auth::user()->balance) </strong>
				<small>
					<a class="link-grey hover-black unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route("frontend.user.point")}}" data-modal-title="Histori Pointku" data-view="modal-lg">[ Histori ]</a>
				</small>
			</p>
			<p class="label-info">
				Referral Code <strong class="text-uppercase"> {{Auth::user()->referral_code}} </strong>
			</p>
			<p class="label-info">
				Kuota Invite Refferal <strong>{{Auth::user()->quota}} </strong>
			</p>
			<p class="label-info">
				Downline 
				<strong>{{Auth::user()->downline}} </strong> 
				<small><a class="link-grey hover-black unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route('frontend.user.downline')}}" data-modal-title="Lihat Downline Saya" data-view="modal-md">[ Lihat Daftar ]</a></small>
			</p>
			<p class="label-info">
			@if (!is_null(Auth::user()->reference))
				Upline 
				<strong>{{Auth::user()->reference}} </strong> 
			@else
				<small><a class="link-grey hover-black unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route('frontend.user.reference.get')}}" data-modal-title="Upline Saya" data-view="modal-md">[ Masukkan Referral ]</a></small>
			@endif
			</p>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row header-info m-l-none m-r-none">
		<div class="col-sm-6">
			<h4>Informasi Pengiriman & Tracking Order</h4>
		</div>
	</div>
	<div class="row content-info m-l-none m-r-none">
		<div class="col-sm-6 border-right">
			<h5 class="title-info m-t-md">
				Alamat Pengiriman
				<small>
					<a class="link-grey hover-black unstyle" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route('frontend.user.address.index')}}" data-modal-title="Ubah Alamat Pengiriman" class="balin-link">
						<i class="fa fa-pencil"> Ubah</i>
					</a>
				</small>
			</h5>
			<p class="label-info">Alamat <span>{{ Auth::user()->address }}</span></p>
			<p class="label-info">No Hp <span>{{ Auth::user()->phone }}</span></p>
			<p class="label-info">Kode Pos <span>{{ Auth::user()->zipcode }}</span></p>
				<!-- <a class="link-grey hover-black unstyle" href="" class="balin-link text-right">Atur Buku Alamat</a><br/> -->
			</p>
			<p class="clearfix m-b-xxs">&nbsp;</p>
		</div>
		<div class="col-sm-6">
			<h5 class="title-info m-t-md">Tracking Order</h4>
		</div>
	</div>


	<!-- Modal Balance -->
	<div id="modal-balance" class="modal modal-user-information" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		       		<h5 class="modal-title" id="exampleModalLabel">Histori Balance</h5>
		      	</div>
		      	<div class="modal-body ribbon-menu" style="text-align:left">
					
		      	</div>
	   		</div>
	  	</div>
	</div>
@stop

@section('script')
	var view_mode = '';

	$('.modal-user-information').on('show.bs.modal', function(e) {
		var action = $(e.relatedTarget).attr('data-action');
		var title = $(e.relatedTarget).attr('data-modal-title');
		var view_mode = $(e.relatedTarget).attr('data-view');

		$(this).find('.modal-body').html('loading...');
		$(this).find('.modal-title').html(title);
		$(this).find('.modal-dialog').addClass(view_mode);
		$(this).find('.modal-body').load(action);
	});

	$('.modal-balance').on('hide.bs.modal', function(e) {
		$('.modal-dialog').removeClass(view_mode);
		$(this).find('.modal-body').removeData('bs.modal');
	});
@stop

@section('script_plugin')
	@include('plugins.datepicker')
@stop