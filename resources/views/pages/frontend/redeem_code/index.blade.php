@extends('template.frontend.layout_account')

@section('right_content')
	<div class="clearfix">&nbsp;</div>

	<div class="row point-info m-l-none m-r-none">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 header-info p-r-md p-l-md">
			<div class="row p-md">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-r-none">
					<h4 class="p-b-md text-left">Referral Code 
						<small>
							<a href="#" class="link-white hover-gold unstyle help" data-toggle="modal" data-target=".referral-user-information"><i class="fa fa-question-circle"></i></a>
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
					<h4 class="p-b-md">Balin Point Anda 
						<small>
							<a href="#" class="link-white hover-gold unstyle help" data-toggle="modal" data-target=".point-user-information"><i class="fa fa-question-circle fa-1x"></i></a>
						</small>
					</h4>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p class="text-right hidden-xs"><strong>@money_indo(Auth::user()->balance) </strong></p>
					<p class="text-left hidden-sm hidden-md hidden-lg"><strong>@money_indo(Auth::user()->balance) </strong></p>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a class="link-white hover-gold unstyle text-right hidden-xs" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route("frontend.user.point")}}" data-modal-title="History Balin Point Anda" data-view="modal-lg">[ History ]</a>
					<a class="link-white hover-gold unstyle text-left hidden-sm hidden-md hidden-lg" href="#" data-toggle="modal" data-target=".modal-user-information" data-action="{{route("frontend.user.point")}}" data-modal-title="History Balin Point Anda" data-view="modal-lg">[ History ]</a>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row point-info m-l-none m-r-none">
		<div class="col-sm-12 header-info p-lg" id="panel-voucher-normal">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					@if (Auth::user()->reference!=false || is_null(Auth::user()->reference))
						@if (is_null(Auth::user()->reference))
							<div class="row p-b-md p-t-none">
								<div class="col-md-12">
									<h4 class="m-t-sm p-b-sm">Punya Referral Code ?</h4>
								</div>	
							</div>
							{!! Form::open(['url' => route('frontend.user.reference.post')]) !!}
								<div class="row">
									<div class="col-md-12">
										<div class="input-group" style="position:relative">
											<div class="loading-voucher text-center hide" style="line-height:30px">
												{!! HTML::image('Balin/web/image/loading.gif', null, ['style' => 'width:20px']) !!}
											</div>
											{!! Form::hidden('from', 'frontend.redeem.index') !!}
											{!! Form::input('text', 'referral_code', null, [
													'class' => 'form-control hollow transaction-input-voucher-code m-b-sm check-voc-ref',
													'placeholder' => 'Masukkan referral code anda',
													'data-action' => route('frontend.user.reference.post')
											]) !!}
											<span class="input-group-btn">
												<button type="submit" class="btn-hollow hollow-black" data-action="{{ route('frontend.user.reference.post') }}">Gunakan</button>
											</span>
										</div>
									</div>
								</div>
							{!! Form::close() !!}
						@else
							<div class="row p-b-md p-t-none">
								<div class="col-md-12 text-center">
									<h4 class="m-t-sm p-b-sm">REFERRAL ANDA</h4>
								</div>	
							</div>
							<div class="row">
								<div class="col-md-12 text-center">
									{{ Auth::user()->reference }}
								</div>
							</div>
						@endif
					@else
						<div class="row p-b-md p-t-none">
							<div class="col-md-12 text-center">
								<h4 class="m-t-sm p-b-sm">REFERRAL ANDA</h4>
							</div>	
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								{{ Auth::user()->reference }}
							</div>
						</div>
					@endif
				</div>
			</div>
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
		       		<h5 class="modal-title" id="exampleModalLabel">Balin Point</h5>
		      	</div>
		      	<div class="modal-body mt-75 mobile-m-t-10" style="text-align:left">
					<p>Balin Point ini adalah voucher discount yang dapat anda gunakan untuk pembelian produk di Balin</p>
					<p>Untuk menambah jumlah Balin Point ini, ajak teman dan kerabat anda untuk melakukan registrasi di situs Balin.id dan berikan kode referal anda kepada mereka. Dengan menggunakan kode referal anda, teman anda akan mendapatkan Balin Point sebesar Rp. 50.000 dan anda akan mendapatkan Balin Point sebesar Rp. 10.000.</p>
					<p>Kode referal anda, pada mulanya hanya dapat anda berikan kepada 10 orang teman anda. Apabila teman yang menggunakan kode referal anda melakukan pembelian, anda akan mendapatkan tambahan kuota tersebut menjadi 11 dan anda akan mendapatkan Balin Point sebesar Rp. 10.000, dan demikian seterusnya tanpa ada batasnya.</p>
					<p>Semakin banyak teman yang menggunakan referal anda dan semakin sering teman yang anda referensikan melakukan pembelian, semakin besar voucher yang anda dapatkan.</p>

					<p>Balin Point tidak dapat diuangkan.</p>
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
					<p>Kode referal adalah kode akun anda di Balin.id. Anda dapat mengajak teman atau kerabat anda untuk mendaftar ke situs Balin.id dan berikan kode referal anda. Dengan menggunakan kode referal anda, teman anda akan mendapatkan Point Balin sebesar Rp. 50.000 dan anda akan mendapatkan Balin Point sebesar Rp. 10.000</p>
					<p>Kode referal anda, pada mulanya hanya dapat anda berikan kepada 10 orang teman anda. Apabila teman yang menggunakan kode referal anda melakukan pembelian, anda akan mendapatkan tambahan kuota tersebut menjadi 11 dan anda akan mendapatkan Balin Point sebesar Rp. 10.000, dan demikian seterusnya tanpa ada batasnya.</p>
					<p>Semakin banyak teman yang menggunakan referal anda dan semakin sering teman yang anda referensikan melakukan pembelian, semakin besar voucher yang anda dapatkan.</p>

					<p>Balin Point tidak dapat diuangkan.</p>
		      	</div>
	   		</div>
	  	</div>
	</div>
@stop

@section('script')
	$('button.check-voc-ref').click( function() {
		console.log('yes');
		inp = $('input.check-voc-ref');
		voucher = get_voucher(inp);
		show_voucher(voucher, inp);
	});

	function get_voucher(e) {
		value = e.val();
		action = e.attr('data-action');
		var gv;
		
		$.ajax({
			url: action,
			type: 'post',
			dataType: 'json', 
			async: false,
			data: {voucher: value},
			beforeSend: function() {
				$('.loading-voucher').removeClass('hide');
			},
			success: function(data) {
				// $('.loading-voucher').addClass('hide');
				gv = data;
			}
		});

		return gv;
	}

	function show_voucher(e, p) 
	{
		if (e.type=='success')
		{
			panel_voucher = $('.panel-form-voucher');
			panel_voucher_device = $('.panel-form-voucher-device');

			modal_notif = $('.modal-notif');
			modal_notif.find('.title').children().html('');
			modal_notif.find('.content').html(e.msg);

			set_voucher_id(p);

			if (e.discount==true) {
				$('.shippingcost').text('IDR 0');
				$('.shippingcost').attr('data-s', 0);
				$('.shippingcost').attr('data-v', 1);
			}

			setTimeout( function() {
				$('.loading-voucher').addClass('hide');
				panel_voucher.html('<p class="m-b-none">'+e.msg+'</p>');
				panel_voucher_device.html('<p class="m-b-none text-center">'+e.msg+'</p>');
			}, 2000);

			$('#notif-window').modal('show');
		}
		else if (e.type=='error')
		{
			setTimeout( function() {
				$('.loading-voucher').addClass('hide');
			}, 1000);
			
			modal_notif = $('.modal-notif');
			modal_notif.find('.title').children().html('');
			modal_notif.find('.content').html(e.msg);

			p.addClass('error');

			$('#notif-window').modal('show');
		}
	}

	$('#modal-balance').on('hidden.bs.modal', function () {
		window.history.pushState('obj', 'newtitle', '/profile');
		return false;
	})

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

	$(window).resize(function() {
		wd = $(this).width();

		if (wd < 750) {
			$('.panel-right').removeClass('border-left');
			$('.panel-right').addClass('border-top');
		} else {
			$('.panel-right').removeClass('border-top');
			$('.panel-right').addClass('border-left');
		}
	});

	$(window).load(function() {
		wd = $(this).width();
		if (wd < 750) {
			$('.panel-right').removeClass('border-left');
			$('.panel-right').addClass('border-top');
		} else {
			$('.panel-right').removeClass('border-top');
			$('.panel-right').addClass('border-left');
		}
	});
@stop

@section('script_plugin')
	@include('plugins.input-mask')
	@include('plugins.notif', ['data' => ['title' => 'Terima Kasih', 'content' => 'Produk telah ditambahkan di cart']])
@stop