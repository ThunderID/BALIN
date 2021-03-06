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
				<div class="clearfix hidden-xs">&nbsp;</div>
				@include('widgets.alerts')
			</div>
		</div>
		{!! Form::open(['url' => route('frontend.post.checkout'), 'method' => 'POST', 'novalidate' => 'novalidate', 'class' => 'no_enter']) !!}
			{!! Form::hidden('voucher_code', '', ['class' => 'voucher_code']) !!}
			<div class="row">
				@if ($carts)
				<div class="col-xs-12 col-sm-12 col-md-7">
				@else
				<div class="col-xs-12 col-sm-12 col-md-12">
				@endif
					<div class="row">
						<div class="col-xs-12 col-md-12 col-sm-12 chart-div">
							<div class="row chart-header m-t-sm">
								<div class="col-md-2 col-sm-2 hidden-xs">
									<p>Produk</p>
								</div>
								<div class="col-md-10 col-sm-10 hidden-xs">
									<div class="row">
										<div class="col-sm-2 col-md-2"></div>
										<div class="col-sm-1 col-md-1" style="margin-left:-21px;margin-right:20px;">
											<p class="text-right">Kuantitas</p>
										</div>
										<div class="col-sm-3 col-md-3">
											<p class="text-right">Harga</p>
										</div>
										<div class="col-sm-3 col-md-3">
											<p class="text-right">Diskon</p>
										</div>
										<div class="col-md-3 col-sm-3">
											<p class="text-right">Total</p>
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

					<!-- total normal -->
					<div class="row">
						@if ($carts)
							<div class="col-lg-12 col-md-12 hidden-sm hidden-xs checkout-bottom panel-subtotal" id="panel-subtotal-normal">
								<div class="clearfix">&nbsp;</div>
								<div class="row m-l-none m-r-none">
									<div class="col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left text-left border-bottom">
										<span class="">Subtotal</span>
									</div>
									<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right border-bottom">
										<span class="text-right" id="total">@money_indo($total)</span>
									</div>
								</div>
								<div class="row m-l-none m-r-none">
									<div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 text-left">
										<span class="">Balin Point Anda</span>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 text-right">
										<span class="text-right" id="point">@money_indo(Auth::user()->balance)</span>
									</div>	
								</div>
								<div class="row m-l-none m-r-none">
									<div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 text-left">
										<span >Biaya Pengiriman</span>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 text-right">
										<span class="text-right shippingcost" data-s="0" data-v="0">@money_indo(0)</span>
									</div>	
								</div>
								<div class="row m-l-none m-r-none">
									<div class="col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left border-bottom">
										<span>
											Pengenal Pembayaran <a href="#" class="link-grey hover-black" data-toggle="modal" data-target=".modal-unique-number"><i class="fa fa-question-circle"></i></a>
										</span>
									</div>
									<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right border-bottom">
										<span class="text-right uniquenumber text-red" data-unique="{{ $transaction['unique_number'] }}">@money_indo_negative($transaction['unique_number'])</span>
									</div>
								</div>
								<div class="row m-l-none m-r-none">
									<div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 text-left">
										<h4>Total Pembayaran</h4>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5">
										<h4 class="text-right subtotal" style="font-weight: bold;">
											<?php $total_pembayaran = $total - Auth::user()->balance - $transaction['unique_number']; ?>
											@if ($total_pembayaran && $total_pembayaran < 0)
												@money_indo(0)
											@else
												@money_indo($total_pembayaran)
											@endif
										</h4>
									</div>	
								</div>
								<div class="clearfix">&nbsp;</div>
							</div>
						@endif
					</div>
					<div class="row clearfix hidden-xs">
						&nbsp;
					</div>
				</div>

				@if ($carts)
					<div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-1">
						<div class="row m-b-md">
							<div class="col-md-12 hidden-xs hidden-sm hidden-md hidden-lg panel-voucher panel-form-voucher" id="panel-voucher-normal">
								<div class="row p-b-sm">
									<div class="col-md-12">
										<span class="voucher-title">Punya Promo Code ?</span>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="input-group" style="position:relative">
											<div class="loading-voucher text-center hide">
												{!! HTML::image('Balin/web/image/loading.gif', null, []) !!}
											</div>
											{!! Form::input('text', 'voucher', null, [
													'class' => 'form-control hollow transaction-input-voucher-code m-b-sm voucher-desktop',
													'placeholder' => 'Masukkan promo code anda',
													'data-action' => route('frontend.any.check.voucher')
											]) !!}
											<span class="input-group-btn">
												<button type="button" class="btn-hollow btn-hollow-voucher voucher-desktop" data-action="{{ route('frontend.any.check.voucher') }}">Gunakan</button>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 p-t-sm" style="background-color:#fff">
								<div class="row">
									<div class="m-t-sm hidden-lg hidden-md hidden-sm col-xs-12">
										<h3 class="m-t-none m-b-md hollow-label">ALAMAT PENGIRIMAN</h3>
									</div>						
									<div class="col-md-12 hidden-xs">
										<h3 class="m-t-none m-b-md hollow-label">ALAMAT PENGIRIMAN</h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="hollow-label" for="name">Pilih Alamat</label>
											<select class="form-control hollow choice_address" name="address_id" id="address_id">
												@foreach($addresses as $key => $value)
													<option value={{$value['id']}} data-receiver-name="{{ $value['receiver_name'] }}" data-address="{{ $value['address'] }}" data-kodepos="{{ $value['zipcode'] }}" data-phone="{{ $value['phone'] }}" data-action="{{ route('frontend.address.get.ajax', $value['id']) }}" title="{{ $value['address'] }}{{ $value['zipcode'] }}">{{ $value['receiver_name'] }} - {{$value['address']}}</option>
												@endforeach
												<option value="0" selected>Tambah Alamat Baru</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="hollow-label" for="">Nama Penerima</label>
											{!! Form::input('text', 'receiver_name', Auth::user()->name, [
													'class' 		=> 'form-control hollow ch-name',
											]) !!}
										</div>
									</div>
								</div>
								<div class="row new-address">
									<div class="col-md-12">
										<div class="form-group">
											<label class="hollow-label" for="">Alamat</label>
											{!! Form::textarea('address', null, [
													'class' 		=> 'form-control hollow ch-address',
													'rows'      => '2',
													'style'     => 'resize:none;',
											]) !!}
										</div>
										<div class="form-group">
											<label class="hollow-label" for="">Kode Pos</label>
											{!! Form::input('number', 'zipcode', null, [
													'class' 		=> 'form-control hollow ch-zipcode',
													'id'			=> 'zipcode'
											]) !!}
										</div>
										<div class="form-group">
											<label class="hollow-label" for="">No. Telp</label>
											{!! Form::input('text', 'phone', null, [
													'class' 		=> 'form-control hollow ch-phone',
											]) !!}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 hidden-xs hidden-sm">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="term" value="1" tabindex="1" required>
												Saya menyetujui <a href="#" data-toggle="modal" data-target="#tnc"><strong>Syarat & Ketentuan</strong></a> pembelian barang di Balin 
											</label>
										</div>
									</div>
								</div>
								<div class="clearfix">&nbsp;</div>
								<div class="row">
									<div class="col-md-12 hidden-xs hidden-sm">
										<div class="form-group text-right">
											<button type="submit" class="btn-hollow hollow-black-border" tabindex="7">Checkout</button>
										</div>        
									</div>        
								</div>  
							</div>
						</div>
					</div>
				@endif
				<div class="clearfix hidden-xs">&nbsp;</div>
			</div>


			<!-- total tablet -->
			@if ($carts)
				<div class="row ">
					<div class="hidden-xs hidden-sm hidden-md hidden-lg col-sm-12 panel-voucher panel-form-voucher-device p-t-sm">
						<div class="row p-b-sm">
							<div class="col-sm-12 text-center">
								<span class="voucher-title">PUNYA PROMO CODE ?</span>
							</div>	
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="input-group" style="position:relative">
									<div class="loading-voucher text-center hide">
										{!! HTML::image('Balin/web/image/loading.gif', null, []) !!}
									</div>
									{!! Form::input('text', 'voucher', null, [
											'class' => 'form-control hollow transaction-input-voucher-code m-b-sm voucher-tablet',
											'placeholder' => 'Masukkan promo code anda',
											'data-action' => route('frontend.any.check.voucher')
									]) !!}
									<span class="input-group-btn">
										<button type="button" class="btn-hollow btn-hollow-voucher voucher-tablet" data-action="{{ route('frontend.any.check.voucher') }}">Gunakan</button>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="hidden-lg hidden-md col-sm-12 hidden-xs p-t-sm panel-voucher checkout-bottom panel-subtotal" style="color:#333;">
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-7 text-left">
									<span>Total</span>
								</div>
								<div class="col-sm-5 text-right">
									<span class="text-right" id="total">@money_indo($total)</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-7 text-left">
									<span>Balin Point Anda</span>
								</div>
								<div class="col-sm-5 text-right">
									<span class="text-right" id="point">@money_indo(Auth::user()->balance)</span>
								</div>	
							</div>	
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-7 text-left">
									<span>Biaya Pengiriman</span>
								</div>
								<div class="col-sm-5 text-right">
									<span class="text-right shippingcost" data-s="0" data-v="0">@money_indo(0)</span>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-7 text-left border-bottom grey">
									<span>
										Pengenal Pembayaran  <a href="#" class="link-grey hover-black" data-toggle="modal" data-target=".modal-unique-number"><i class="fa fa-question-circle"></i></a>
									</span>
								</div>
								<div class="col-sm-5 text-right border-bottom grey">
									<span class="text-right uniquenumber" data-unique="{{ $transaction['unique_number'] }}">@money_indo_negative($transaction['unique_number'])</span>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-7 text-left">
									<h4>Total Pembayaran</h4>
								</div>
								<div class="col-sm-5">
									<h4 class="text-right subtotal" style="font-weight: bold;">
										<?php $total_pembayaran = $total - Auth::user()->balance - $transaction['unique_number']; ?>
										@if ($total_pembayaran && $total_pembayaran < 0)
											@money_indo(0)
										@else
											@money_indo($total_pembayaran)
										@endif
									</h4>
								</div>	
							</div>	
						</div>
					</div>
				</div>

				<div class="row">
					<div class="hidden-lg hidden-md col-sm-12 hidden-xs p-t-sm panel-voucher checkout-bottom panel-subtotal" style="background-color:white; color:black;">
						<div class="row clearfix">&nbsp;</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-12 text-center">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="term" value="1" tabindex="1" required>
											Saya menyetujui <a href="#" data-toggle="modal" data-target="#tnc"><strong>Syarat & Ketentuan</strong></a> pembelian barang di Balin 
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row clearfix">&nbsp;</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-12 text-center">
									<div class="form-group">
										<button type="submit" class="btn-hollow btn-block hollow-black-border" tabindex="7">Checkout</button>
									</div>        
								</div>        
							</div>        
						</div> 
					</div>
					<div class="clearfix hidden-xs">&nbsp;</div>
					<div class="clearfix hidden-xs">&nbsp;</div>
				</div>
			@endif

			<!-- total mobile -->
			<div class="row" style="background-color:black;">
				<div class="hidden-lg hidden-md hidden-sm hidden-xs col-xs-12 panel-voucher panel-form-voucher-device" style="background-color:#111; border-bottom:1px solid #fff">
					<div class="row p-b-sm">
						<div class="col-xs-12">
							<span class="voucher-title">PUNYA PROMO CODE ?</span>
						</div>	
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="input-group p-b-xxs" style="position:relative">
								<div class="loading-voucher text-center hide">
									{!! HTML::image('Balin/web/image/loading.gif', null, []) !!}
								</div>
								{!! Form::input('text', 'voucher', null, [
										'class' => 'form-control hollow transaction-input-voucher-code m-b-sm voucher-mobile',
										'placeholder' => 'Masukkan promo code anda',
										'data-action' => route('frontend.any.check.voucher')
								]) !!}
								<span class="input-group-btn">
									<button type="button" class="btn-hollow btn-hollow-voucher voucher-mobile" data-action="{{ route('frontend.any.check.voucher') }}">Gunakan</button>
								</span>
							</div>
						</div>
					</div>
				</div>	

				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<div class="row p-t-sm m-b-none">
						<div class="col-xs-12">
							<h4 style="color:#FFF;" class="text-center">Total</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<h3 style="color:#fff;" class="text-center m-t-none" id="total">
								@if (isset($total))
									@money_indo($total)
								@endif
							</h3>
						</div>
					</div>
					<div class="row m-b-none">
						<div class="col-xs-12">
							<h4 style="color:#FFF;" class="text-center">Balin Point Anda</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<h3 style="color:#fff;" class="text-center m-t-none">
								@money_indo(Auth::user()->balance)
							</h3>
						</div>
					</div>
					<div class="row m-b-none">
						<div class="col-xs-12">
							<h4 style="color:#FFF;" class="text-center">Biaya Pengiriman</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<h3 style="color:#fff;" class="text-center m-t-none shippingcost" data-s="0" data-v="0">
								@money_indo(0)
							</h3>
						</div>
					</div>
					<div class="row m-b-none">
						<div class="col-xs-12">
							<h4 style="color:#fff;" class="text-center">Pengenal Pembayaran  <a href="#" class="link-grey hover-black" data-toggle="modal" data-target=".modal-unique-number"><i class="fa fa-question-circle"></i></a></h4>
						</div>
					</div>
					<div class="row m-b-sm">
						<div class="col-xs-12">
							<h3 style="color:#fff;" class="text-center m-t-none uniquenumber" data-unique="{{ $transaction['unique_number'] }}">
								@money_indo_negative($transaction['unique_number'])
							</h3>
						</div>
					</div>
					<div class="row m-b-none" style="border-top: 1px solid #fff">
						<div class="col-xs-12">
							<h3 style="color:#fff;" class="text-center">Total Pembayaran</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<h2 style="color:#fff;" class="text-center m-t-none subtotal">
								<?php $total_pembayaran = $total - Auth::user()->balance - $transaction['unique_number']; ?>
								@if ($total_pembayaran && $total_pembayaran < 0)
									@money_indo(0)
								@else
									@money_indo($total_pembayaran)
								@endif
							</h2>
						</div>
					</div>
					<div class="row m-t-sm">
						<div class="col-xs-12" style="border-bottom: 1px solid white">
						</div>
					</div>
				<div class="clearfix hidden-xs">&nbsp;</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 hidden-lg hidden-md hidden-sm">
					<div class="row p-t-lg">
						<div class="col-md-12">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="term" value="1" tabindex="1" required>
									Saya menyetujui <a href="#" data-toggle="modal" data-target="#tnc"><strong>Syarat & Ketentuan</strong></a> pembelian barang di Balin 
								</label>
							</div>
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="row p-b-md p-t-xs">
						<div class="col-md-12">
							<div class="form-group text-right">
								<button type="submit" class="btn-hollow btn-block hollow-black-border" tabindex="7" style="font-size:16px">Checkout</button>
							</div>        
						</div>        
					</div>  			
				</div>
			</div>

		{!! Form::close() !!}
	</div>


	<!-- Term and Condition -->
	<div id="tnc" class="modal modal-left modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="exampleModalLabel">Syarat & Ketentuan</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12" style="color: #000">
							{!! $tc['value'] !!}
						</div>
					</div>
					<div class="row m-t-md">
						<div class="col-md-12">
							<button type="button" class="btn-hollow hollow-black-border" data-dismiss="modal" aria-label="Close">Tutup</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>			
</div>		

<!-- Modal Balance -->
<div id="modal-balance" class="modal modal-unique-number modal-fullscreen fade user-page" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
			<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
	       		<h5 class="modal-title" id="exampleModalLabel">Pengenal Pembayaran </h5>
	      	</div>
	      	<div class="modal-body mt-75 mobile-m-t-0" style="text-align:left">
				Pengenal Pembayaran adalah kode atau angka yang kami gunakan untuk mempermudah bagian finance (keuangan) kami dalam mengenali dana pembayaran yang masuk ke rekening kami. 
				Berbeda dengan toko online lainnya dimana kode seperti ini biasanya akan menambah jumlah pembayaran pelanggan, angka yang kami gunakan selalu minus, sehingga nilai pembayaran yang baru selalu lebih kecil dari nilai yang sebelumnya. Dengan demikian, para pelanggan kami tidak akan merasa dirugikan sepeserpun. 
				Saat ini, Pengenal Pembayaran ini hanya berlaku untuk metode pembayaran transfer saja.
	      	</div>
   		</div>
  	</div>
</div>

@stop

@section('script')
	$(".modal-fullscreen").on('show.bs.modal', function () {
	  	setTimeout( function() {
	    	$(".modal-backdrop").addClass("modal-backdrop-fullscreen");
	  	}, 0);
	});
	$(".modal-fullscreen").on('hidden.bs.modal', function () {
		$(".modal-backdrop").addClass("modal-backdrop-fullscreen");
	});
@stop

@section('script_plugin')
	@include('plugins.checkout-plugin')
	@include('plugins.notif', ['data' => ['title' => 'Terima Kasih', 'content' => 'Produk telah ditambahkan di cart']])
	@include('plugins.form_no_enter')
@stop
