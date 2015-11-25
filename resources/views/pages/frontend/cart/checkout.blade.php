@inject('tc', 'App\Models\StoreSetting')
<?php	
	$carts = Session::get('baskets'); 
	$tc = $tc::type('term_and_condition')->ondate('now')->orderby('started_at', 'desc')->first();
?>
@extends('template.frontend.layout')

@section('content')
	<div class="container m-t-md">
		<div class="row">
			<div class="col-lg-12">
				@include('widgets.breadcrumb')
				<div class="clearfix">&nbsp;</div>
				@include('widgets.alerts')
			</div>
		</div>
		{!! Form::open(['url' => route('frontend.post.checkout'), 'method' => 'POST']) !!}
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7">
					<div class="row">
						<div class="col-xs-12 col-md-12 col-sm-12 chart-div">
							<div class="row chart-header">
								<div class="col-md-1 col-sm-1 hidden-xs">
									<p>Produk</p>
								</div>
								<div class="col-md-11 col-sm-11 hidden-xs">
									<div class="row">
										<div class="col-sm-3 col-md-3"></div>
										<div class="col-sm-3 col-md-3">
											<p class="text-center">Kuantitas</p>
										</div>
										<div class="col-sm-2 col-md-2">
											<p class="text-left">Harga</p>
										</div>
										<div class="col-sm-2 col-md-2">
											<p class="text-left">Diskon</p>
										</div>
										<div class="col-md-2 col-sm-2">
											<p class="text-center">Total</p>
										</div>
									</div>
								</div>
							</div>

							@if ($carts)
								<?php $total = 0; ?>
								@foreach ($carts as $k => $item)
									<?php
										$qty 			= 0;
										foreach ($item['varians'] as $key => $value) 
										{
											$qty 		= $qty + $value['qty'];
										}
									?>
									@include('widgets.checkout_item_list', array(
										"item_list_id"					=> $k,
										"item_list_image"				=> $item['images'],
										"item_list_name" 				=> $item['name'],
										"item_list_qty"					=> $qty,
										"item_list_normal_price"		=> $item['price'],
										"item_list_size"				=> $item['varians'],
										"item_list_discount_price"		=> $item['discount'],
										"item_list_total_price"			=> (($item['price']-$item['discount'])*$qty),
										"item_varians"					=> $item['varians'],
										"item_list_slug"				=> $item['slug'],
										"item_mode"						=> 'new',
									))
									<?php $total += (($item['price']-$item['discount'])*$qty); ?>
								@endforeach
							@else
								<div class="row chart-item">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h4 class="text-center">Tidak ada item di cart</h4>
									</div>
								</div>
							@endif

							<div class="row chart-topLine">
							</div>
						</div>
					</div>

					<!-- mobile -->
					<div class="row hidden-sm hidden-md hidden-lg" style="background-color:black;">
						<div class="hidden-lg hidden-md hidden-sm col-xs-12" >
							<div class="row p-t-xs m-b-none">
								<div class="col-xs-12">
									<h3 style="color:#FFF;" class="text-center">SubTotal</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<h2 style="color:#fff;" class="text-center m-t-none subtotal">
										@if (isset($total))
											@money_indo($total)
										@endif
									</h2>
								</div>
							</div>
						<div class="clearfix hidden-xs">&nbsp;</div>
						</div>
					</div>

						<!-- normal -->
					<div class="row">
						@if ($carts)
							<div class="col-lg-5 col-md-4 col-sm-12 hidden-xs panel-voucher">
								<div class="row p-b-sm">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<span class="voucher-title">Masukkan Kode Voucher</span>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-12">
										{!! Form::input('text', 'voucher_code', null, [
												'class' => 'form-control hollow transaction-input-voucher-code m-b-sm'
										]) !!}
									</div>
								</div>
							</div>
							<div class="col-lg-7 col-md-8 col-sm-12 hidden-xs checkout-bottom panel-subtotal">
								<div class="clearfix">&nbsp;</div>
								<div class="row">
									<div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 text-left">
										<span class="">Point Kamu</span>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 text-right p-r-lg">
										<span class="text-right" id="point">@money_indo(Auth::user()->balance)</span>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 text-left">
										<span >Biaya Pengiriman</span>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 text-right p-r-lg">
										<span class="text-right" id="shippingcost">@money_indo(0)</span>
									</div>	
								</div>
								<div class="row">
									<div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 text-left">
										<h4>SubTotal</h4>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 p-r-lg">
										<h4 class="text-right subtotal" style="font-weight: bold;">
											@if ($total)
												@money_indo($total)
											@endif
										</h4>
									</div>	
								</div>
							</div>
						@endif
					</div>
					<div class="row clearfix hidden-xs">
						&nbsp;
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-1 p-t-sm" style="background-color:#fff">
					<div class="row m-t-md hidden-xs hidden-md hidden-lg">&nbsp;</div>
					<div class="row">
						<div class="col-md-12">
							<h3 class="m-t-none m-b-md hollow-label">ALAMAT PENGIRIMAN</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="hollow-label" for="">Nama Penerima</label>
								{!! Form::input('text', 'receiver_name', null, [
										'class' 		=> 'form-control hollow transaction-input-postal-code',
								]) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="hollow-label" for="name">Pilih Alamat</label>
								<select class="form-control hollow choice_address" name="address_id" id="address_id">
									@foreach($addresses as $key => $value)
										<option value={{$value['id']}}>{{$value['receiver_name']}}</option>
									@endforeach
									<option value="0">Tambah Alamat Baru</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row new-address new-address-hide">
						<div class="col-md-12">
							<div class="form-group">
								<label class="hollow-label" for="">Alamat</label>
								{!! Form::textarea('address', null, [
										'class' 		=> 'form-control hollow transaction-input-address',
										'rows'      => '2',
										'style'     => 'resize:none;',
								]) !!}
							</div>
							<div class="form-group">
								<label class="hollow-label" for="">Kode Pos</label>
								{!! Form::input('number', 'zipcode', null, [
										'class' 		=> 'form-control hollow transaction-input-postal-code',
										'id'			=> 'zipcode'
								]) !!}
							</div>
							<div class="form-group">
								<label class="hollow-label" for="">No. Tlp</label>
								{!! Form::input('text', 'phone', null, [
										'class' 		=> 'form-control hollow transaction-input-phone',
								]) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="checkbox">
								<label>
									{!! Form::input('checkbox', 'term', '1', ['required' => true]) !!}
									I have read the <a href="#" data-toggle="modal" data-target="#tnc"><strong>Term & Condition</strong></a> and willing to process this transaction 
								</label>
							</div>
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group text-right">
								<button type="submit" class="btn-hollow hollow-black-border" tabindex="7">Checkout</button>
							</div>        
						</div>        
					</div>    	
				</div>
				<div class="clearfix hidden-xs">&nbsp;</div>
			</div>
		{!! Form::close() !!}
	</div>


	<div id="tnc" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="exampleModalLabel">Term & Condition</h4>
				</div>
				<div class="modal-body ribbon-menu">
					<div class="row">
						<div class="col-md-12">
							{!! $tc['value'] !!}
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button type="button" class="btn-hollow hollow-black-border" data-dismiss="modal" aria-label="Close">Ok</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>			
</div>		


@stop

@section('script')
	$('.choice_address').on('change', function() {
		var val = $(this).val();
		if (val == 0) {
			$('.new-address').removeClass('new-address-hide');
			$('.new-address').addClass('new-address-show');

			jQuery('#zipcode').on('input propertychange paste', function() {
				GetShippingCost( {'zipcode' : $( "#zipcode" ).val()} );
			});			
		}
		else {
			$('.new-address').removeClass('new-address-show');
			$('.new-address').addClass('new-address-hide');
			GetShippingCost( {'address' : $( "#address_id" ).val()} );
		}
	});

	function setModalMaxHeight(element) {
		this.$element     = $(element);
		var dialogMargin  = $(window).width() > 767 ? 62 : 22;
		var contentHeight = $(window).height() - dialogMargin;
		var headerHeight  = this.$element.find('.modal-header').outerHeight() || 2;
		var footerHeight  = this.$element.find('.modal-footer').outerHeight() || 2;
		var maxHeight     = contentHeight - (headerHeight + footerHeight);

		this.$element.find('.modal-content').css({
			'overflow': 'hidden'
		});

		this.$element.find('.modal-body').css({
			'max-height': maxHeight,
			'overflow-y': 'auto'
		});
	}

	$('.modal').on('show.bs.modal', function() {
		$(this).show();
		setModalMaxHeight(this);
	});

	$(window).resize(function() {
		if ($('.modal.in').length != 0) {
			setModalMaxHeight($('.modal.in'));
		}
	});

   function GetShippingCost(e){
		$.post( "{{route('frontend.any.zipcode')}}", e)
			.done(function( data ) {
			$("#shippingcost").text(data);
			countSubTotal();
		});        
    };

    function countSubTotal(){
    	var to = $.trim($("#total").text().replace(/\./g, '')).substring(4);
    	var sc = ($("#shippingcost").text().replace(/\./g, '')).substring(4);
    	var yp = ($("#point").text().replace(/\./g, '')).substring(4);
    	to = parseInt(to);
    	sc = parseInt(sc);
    	yp = parseInt(yp);

    	var st = 'IDR ' + (to + sc - yp);

		$(".subtotal").text(addCommas(st));


		function addCommas(nStr)
		{
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + '.' + '$2');
			}
			return x1 + x2;
		};
	}
@stop
