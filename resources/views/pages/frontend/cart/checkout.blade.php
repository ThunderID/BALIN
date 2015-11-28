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
		{!! Form::open(['url' => route('frontend.post.checkout'), 'method' => 'POST', 'novalidate' => 'novalidate']) !!}
			{!! Form::hidden('voucher_code', '', ['class' => 'voucher_code']) !!}
			<div class="row">
				@if ($carts)
				<div class="col-xs-12 col-sm-12 col-md-7">
				@else
				<div class="col-xs-12 col-sm-12 col-md-12">
				@endif
					<div class="row">
						<div class="col-xs-12 col-md-12 col-sm-12 chart-div">
							<div class="row chart-header">
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
								<div class="row">
									<div class="col-lg-5 col-lg-offset-2 col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 text-left">
										<span class="">Poin Anda</span>
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
										<span class="text-right shippingcost">@money_indo(0)</span>
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
							<div class="col-md-12 hidden-sm hidden-xs panel-voucher panel-form-voucher" id="panel-voucher-normal">
								<div class="row p-b-sm">
									<div class="col-md-12">
										<span class="voucher-title">Masukkan Kode Voucher</span>
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
													'placeholder' => 'Masukkan kode voucher anda',
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
													<option value={{$value['id']}} selected>{{$value['address']}}</option>
												@endforeach
												<option value="0">Tambah Alamat Baru</option>
											</select>
										</div>
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
									<div class="col-md-12 hidden-xs hidden-sm">
										<div class="checkbox">
											<label>
												{!! Form::input('checkbox', 'term', '1', ['required' => true]) !!}
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
					<div class="hidden-lg hidden-md col-sm-12 hidden-xs panel-voucher panel-form-voucher-device p-t-sm">
						<div class="row p-b-sm">
							<div class="col-sm-12 text-center">
								<span class="voucher-title">Masukkan Kode Voucher</span>
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
											'placeholder' => 'Masukkan kode voucher anda',
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
									<span>Poin Anda</span>
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
									<span class="text-right shippingcost">@money_indo(0)</span>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-7 text-left">
									<h4>SubTotal</h4>
								</div>
								<div class="col-sm-5">
									<h4 class="text-right subtotal" style="font-weight: bold;">
										@if ($total)
											@money_indo($total)
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
											{!! Form::input('checkbox', 'term', '1', ['required' => true]) !!}
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
				<div class="hidden-lg hidden-md hidden-sm col-xs-12 panel-voucher panel-form-voucher-device" style="background-color:#111; border-bottom:1px solid #fff">
					<div class="row p-b-sm">
						<div class="col-xs-12">
							<span class="voucher-title">Masukkan Kode Voucher</span>
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
										'placeholder' => 'Masukkan kode voucher anda',
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
							<h4 style="color:#FFF;" class="text-center">Sub Total</h4>
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
							<h4 style="color:#FFF;" class="text-center">Poin Anda</h4>
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
					<div class="row m-b-sm">
						<div class="col-xs-12">
							<h3 style="color:#fff;" class="text-center m-t-none shippingcost">
								@money_indo(0)
							</h3>
						</div>
					</div>


					<div class="row m-b-none" style="border-top: 1px solid #fff">
						<div class="col-xs-12">
							<h3 style="color:#fff;" class="text-center">Total</h3>
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
									{!! Form::input('checkbox', 'term', '1', ['required' => true]) !!}
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
	<div id="tnc" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="exampleModalLabel">Syarat & Ketentuan</h4>
				</div>
				<div class="modal-body ribbon-menu">
					<div class="row">
						<div class="col-md-12">
							{!! $tc['value'] !!}
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button type="button" class="btn-hollow hollow-black-border" data-dismiss="modal" aria-label="Close">Tutup</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>			
</div>		


@stop

@section('script_plugin')
	@include('plugins.checkout-plugin')
@stop
