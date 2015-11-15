<div class="row chart-item">
	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="row">
			<div class="col-sm-4 col-xs-3">
				 <a href="#">
					<img class="image-responsive m-t-sm" style="width:65px;"  src="{{ $item_list_image }}" >
				 </a>
			</div>
			<div class="col-sm-8 col-xs-8">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h4 class="m-b-xs">{{ $item_list_name }}</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-xs-12">	
						@foreach($item_list_size as $key => $value)
						<p>Size : {{ $value['size'] }} ({{ $value['qty'] }})</p>
						@endforeach
					</div>
				</div>	
				<div class="row chart-item-mobile">
					<div class="hidden-lg hidden-md hidden-sm col-xs-12">
						<div class="row">
							<div class="col-xs-3">
								<h4>Qty</h4>
							</div>
							<div class="col-xs-1 text-right">
								<h4>:</h4>
							</div>
							<div class="col-xs-7">
								@if ($item_mode!='edit')
									<h4 class="text-right">{{ $item_list_qty }}</h4>
								@else
									<div class="form-group">
										<select name="product_qty[]" class="form-control hollow product-qty-mobile">
											@for ($x=1; $x<=10; $x++)
												@if ($x<=$item_list_stock)
													<option value="{{ $x }}" @if($x==$item_list_qty) selected="selected" @endif>{{ $x }}</option>
												@endif
											@endfor
										</select>
									</div>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<h4>Harga</h4>
							</div>
							<div class="col-xs-1 text-right">
								<h4>:</h4>
							</div>
							<div class="col-xs-7 text-right">
								<label class="m-b-sm label-item label-price" data-product-price="{{ $item_list_normal_price }}">
									@money_indo($item_list_normal_price) 
								</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<h4>Diskon</h4>
							</div>
							<div class="col-xs-1 text-right">
								<h4>:</h4>
							</div>
							<div class="col-xs-7 text-right">
								<label class="m-b-sm label-item label-discount" data-product-discout="{{ $item_list_discount_price }}">
									@money_indo($item_list_discount_price) 
								</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="col-xs-12 m-b-xs" style="border-bottom: 1px solid #ccc;">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<h4>Total</h4>
							</div>
							<div class="col-xs-1 text-right">
								<h4>:</h4>
							</div>
							<div class="col-xs-7 text-right">
								<label class="label-item label-total" data-product-total="{{ $item_list_total_price }}">
									@money_indo($item_list_total_price)
								</label>
							</div>
						</div>
					</div>
				</div>						
			</div>
		</div>
	</div>
	<div class="col-md-1 col-sm-1 hidden-xs">
		@if ($item_mode!='edit')
			<h4 class="text-center">{{ $item_list_qty }}</h4>
		@else
			<div class="form-group">
				<select name="product_qty[]" class="form-control hollow m-t-sm product-qty-desktop">
					@for ($x=1; $x<=10; $x++)
						@if ($x<=$item_list_stock)
							<option value="{{ $x }}" @if($x==$item_list_qty) selected @endif>{{ $x }}</option>
						@endif
					@endfor
				</select>
			</div>
		@endif
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs text-right">
		<label class="m-t-sm label-item label-price" data-product-price="{{ $item_list_normal_price }}">@money_indo($item_list_normal_price)</label>
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs text-right">
		<label class="m-t-sm label-item label-discount" data-product-discount="{{ $item_list_discount_price }}">@money_indo($item_list_discount_price)</label>
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs text-right">
		<label class="m-t-sm label-item label-total" data-product-total="{{ $item_list_total_price }}">@money_indo($item_list_total_price)</label>
	</div>
	<div class="col-md-1 col-sm-1 hidden-xs">
		@if($item_mode!='checkout')
		<a href="{{ route('frontend.cart.destroy', $item_list_id) }}" class="btn-hollow btn-hollow-xs hollow-black pull-right m-t-sm">
			<i class="fa fa-times"></i>
		</a>
		@endif
	</div>
	<div class="hidden-lg hidden-md hidden-sm col-xs-12">
		@if($item_mode!='checkout')
		<div class="row">
			<div class="col-xs-12">
				<a href="{{ route('frontend.cart.destroy', $item_list_id) }}" class="btn-hollow hollow-black btn-block m-t-md">
					<i class="fa fa-times"></i> Hapus dari Cart
				</a>
			</div>
			<div class="clearfix">&nbsp;</div>
		</div>
		@endif
	</div>
</div>