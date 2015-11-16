<div class="row chart-item">
	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="row">
			<div class="col-sm-5 col-xs-3">
				 <a href="#">
					<img class="img-responsive m-t-sm" src="{{ $item_list_image }}" >
				 </a>
			</div>
			<div class="col-sm-7 col-xs-7">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h4 class="m-b-xs">{{ $item_list_name }}</h4>
					</div>
				</div>
				<div class="row hidden-xs">
					<div class="col-sm-12 col-xs-12">	
						@foreach($item_list_size as $key => $value)
							<p class="m-t-xs m-b-md">Size : {{ $value['size'] }}</p>
						@endforeach
					</div>
				</div>	
				<div class="row hidden-sm hidden-md hidden-lg">
					<div class="col-sm-12">
						@foreach ($item_varians as $k => $v)
							<div class="row">
								<div class="col-xs-3">
									<p class="m-t-xs m-b-md">Size {{ $value['size'] }}</p>
								</div>
								<div class="col-xs-1 text-right">
									<p class="m-t-xs m-b-md">:</p>
								</div>
								<div class="col-xs-4 col-xs-offset-2">
									<div class="row qty-hollow-cart m-t-xs m-b-md">
										<div class="col-sm-12">
											<div class="input-group">
											  	<input type="hidden" name="varianids[{{$key}}]" class="form-control" value="{{$value['varian_id']}}">
												<span class="input-group-btn">
													<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number-mobile" disabled="disabled" data-type="minus" data-field="qty-{{strtolower($value['size'])}}[1]">
														<i class="fa fa-minus"></i>
													</button>
												</span>
												<input type="text" name="qty[{{$key}}]" class="form-control input-hollow-cart input-number-mobile" value="{{ $value['qty'] }}" min="0" max="@if(50<=$value['stock']){{ '50' }}@else{{ $value['stock'] }}@endif" data-stock="{{ $value['stock'] }}" data-id="{{ $value['varian_id'] }}" data-name="qty-{{strtolower($value['size'])}}[1]">
												<span class="input-group-btn">
													<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number-mobile" data-type="plus" data-field="qty-{{strtolower($value['size'])}}[1]">
														<i class="fa fa-plus"></i>
													</button>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
				<div class="row chart-item-mobile">
					<div class="hidden-lg hidden-md hidden-sm col-xs-12">
						<div class="row">
							<div class="col-xs-3">
								<h4>Harga</h4>
							</div>
							<div class="col-xs-1 text-right">
								<h4>:</h4>
							</div>
							<div class="col-xs-7 text-right">
								<label class="m-b-sm label-item label-price-mobile" data-product-price="{{ $item_list_normal_price }}">
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
								<label class="label-item label-total-mobile" data-product-total="{{ $item_list_total_price }}">
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
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<h4 class="text-center">&nbsp;</h4>
				</div>
			</div>
			@foreach ($item_varians as $k => $v)
				<div class="row qty-hollow-cart m-b-md">
					<div class="col-sm-12">
						<div class="input-group">
						  	<input type="hidden" name="varianids[{{$k}}]" class="form-control" value="{{$v['varian_id']}}">
							<span class="input-group-btn">
								<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number" @if($v['qty']<0)disabled="disabled"@endif data-type="minus" data-field="qty-{{strtolower($v['size'])}}[{{$v['qty']}}]">
									<i class="fa fa-minus"></i>
								</button>
							</span>
							<input type="text" name="qty[{{$k}}]" class="form-control input-hollow-cart input-number" value="{{ $v['qty'] }}" min="0" max="@if(50<=$v['stock']){{ '50' }}@else{{ $v['stock'] }}@endif" data-stock="{{ $v['stock'] }}" data-id="{{ $v['varian_id'] }}" data-name="qty-{{strtolower($v['size'])}}[{{$v['qty']}}]">
							<span class="input-group-btn">
								<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number" data-type="plus" data-field="qty-{{strtolower($v['size'])}}[{{$v['qty']}}]">
									<i class="fa fa-plus"></i>
								</button>
							</span>
						</div>
					</div>
				</div>
			@endforeach
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
		<label class="m-t-lg label-item label-price" data-price="{{ $item_list_normal_price }}">@money_indo($item_list_normal_price)</label>
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs text-right">
		<label class="m-t-lg label-item label-discount" data-discount="{{ $item_list_discount_price }}">@money_indo($item_list_discount_price)</label>
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs text-right">
		<label class="m-t-lg label-item label-total" data-total="{{ $item_list_total_price }}">@money_indo($item_list_total_price)</label>
	</div>
	<div class="col-md-1 col-sm-1 hidden-xs">
		@if($item_mode!='checkout')
		<a href="{{ route('frontend.cart.destroy', ['id' => $item_list_id]) }}" class="btn-hollow btn-hollow-xs hollow-black pull-right m-t-lg">
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