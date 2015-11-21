<div class="hidden-xs">
	<div class="row chart-item " style="border-bottom: 0.09em solid #ccc">
		<div class="col-sm-2 col-md-1 clearfix">
			<a href="#">
				<img class="img-responsive m-t-sm" style=""  src="{{ $item_list_image }}" >
			</a>
		</div>
		<div class="col-sm-10 col-md-11 p-b-sm">
			<div class="row">
				<div class="col-sm-4 col-md-4">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<a href="{{ route('frontend.product.show', $item_list_slug) }}" class="title"><h4 class="m-b-xs">{{ $item_list_name }}</h4></a>
							<p class="m-b-sm">Size </p>
						</div>
					</div>
				</div>
				<div class="col-sm-8 col-md-8">&nbsp;</div>
			</div>
			<div class="row">
				@foreach($item_list_size as $key => $value)
					<div class="col-sm-1 col-md-1 qty-{{strtolower($value['size'])}}" data-get-flag="qty-{{strtolower($value['size'])}}">
						<p>{{ $value['size'] }}</p>
					</div>
					<div class="col-sm-2 col-md-3" data-get-flag="qty-{{strtolower($value['size'])}}">
						<a href="javascript:void(0);" data-action="{{ route('frontend.cart.destroy', ['cid' => $item_list_id, 'vid' => $key] ) }}" data-cid="{{ $item_list_id }}" data-vid="{{ $key }}" class="btn-delete-varian">(Batal)</a>
					</div>
					<div class="col-sm-1 col-md-1 text-center qty-{{strtolower($value['size'])}}" data-get-flag="qty-{{strtolower($value['size'])}}">
						<div class="row qty-hollow-cart">
							{!! Form::open(['url' => route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key] ), 'method' => 'POST', 'class' => 'form-cart']) !!}
								{!! Form::hidden('cid', $item_list_id, ['class' => 'cid']) !!}
								{!! Form::hidden('vid', $key, ['class' => 'vid']) !!}
								<div class="input-group">
									<input type="hidden" name="varianids[{{$key}}]" class="form-control" value="{{$value['varian_id']}}">
									<span class="input-group-btn">
										<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number" 
											@if($value['qty'] <= 0)disabled="disabled"@endif data-type="minus" data-field="qty-{{strtolower($value['size'])}}[1]" 
											data-get-flag="qty-{{strtolower($value['size'])}}" data-price="{{ $item_list_normal_price }}" 
											data-action-update="{{ route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key]) }}">
											<i class="fa fa-minus"></i>
										</button>
									</span>
									<input type="text" name="qty[{{$key}}]" class="form-control input-hollow-cart input-number qty pqty" value="{{ $value['qty'] }}" 
										min="0" max="@if(50<=$value['stock']){{ '50' }}@else{{ $value['stock'] }}@endif" 
										data-stock="{{ $value['stock'] }}" data-id="{{ $value['varian_id'] }}" data-name="qty-{{strtolower($value['size'])}}[1]">
									<span class="input-group-btn">
										<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number" data-type="plus" 
										data-field="qty-{{strtolower($value['size'])}}[1]" data-get-flag="qty-{{strtolower($value['size'])}}" 
										data-price="{{ $item_list_normal_price }}" 
										data-action-update="{{ route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key]) }}">
											<i class="fa fa-plus"></i>
										</button>
									</span>
								</div>
							{!! Form::close() !!}   
						</div>
					</div>
					<div class="col-sm-1 hidden-xs hidden-md hidden-lg"><p>&nbsp;</p></div>
					<div class="col-sm-3 col-md-3 text-right label-price qty-{{strtolower($value['size'])}}" data-price="{{ $item_list_normal_price }}" 
						data-get-price="qty-{{strtolower($value['size'])}}" data-get-flag="qty-{{strtolower($value['size'])}}">
						@money_indo($item_list_normal_price)
					</div>
					<div class="col-sm-2 col-md-2 text-right qty-{{strtolower($value['size'])}}" data-get-flag="qty-{{strtolower($value['size'])}}">
						@money_indo($item_list_discount_price) 
					</div>
					<div class="col-sm-2 col-md-2 text-right label-total qty-{{strtolower($value['size'])}}" 
						data-total="{{ ($item_list_normal_price - $item_list_discount_price) * $value['qty'] }}" data-get-total="qty-{{strtolower($value['size'])}}" 
						data-get-flag="qty-{{strtolower($value['size'])}}">
						@money_indo(($item_list_normal_price - $item_list_discount_price) * $value['qty'])
						<div class="clearfix">&nbsp;</div>	
						<div class="clearfix">&nbsp;</div>
						<div class="clearfix">&nbsp;</div>
					</div>	
				@endforeach
			</div>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<div class="row">
				<div class="col-xs-12">
					<a href="{{ route('frontend.cart.destroy', ['cid' => $item_list_id] ) }}" class="btn-hollow hollow-black btn-block m-t-md">
						<i class="fa fa-times"></i> Hapus dari Cart
					</a>
				</div>
				<div class="clearfix">&nbsp;</div>
			</div>
		</div>
	</div>
</div>
<div class="hidden-sm hidden-md hidden-lg">
	<div class="row chart-item">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-sm-2 col-xs-12">
					 <a href="#">
						<img class="img-responsive m-t-sm" src="{{ $item_list_image }}" >
					 </a>
				</div>
				<div class="col-sm-10 col-xs-12">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<h4 class="m-b-xs">{{ $item_list_name }}</h4>
							<p class="m-t-sm m-b-sm">Size :</p>
						</div>
					</div>
					@foreach($item_list_size as $key => $value)
						<div class="row m-b-md">
							<div class="col-sm-9 col-xs-8">
								<p class="m-t-xxs m-b-xxs">{{ $value['size'] }}</p>
							</div>
							<div class="col-xs-1">&nbsp;</div>
							<div class="col-xs-1">
								<div class="row qty-hollow-cart text-right">
									{!! Form::open(['url' => route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key] ), 'method' => 'POST', 'class' => 'form-cart']) !!}
										{!! Form::hidden('cid', $item_list_id, ['class' => 'cid']) !!}
										{!! Form::hidden('vid', $key, ['class' => 'vid']) !!}
										<div class="input-group">
											<input type="hidden" name="varianids[{{$key}}]" class="form-control" value="{{$value['varian_id']}}">
											<span class="input-group-btn">
												<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number" 
													@if($value['qty'] <= 0)disabled="disabled"@endif data-type="minus" data-field="qty-{{strtolower($value['size'])}}[1]" 
													data-get-flag="qty-{{strtolower($value['size'])}}" data-price="{{ $item_list_normal_price }}" 
													data-action-update="{{ route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key]) }}" >
													<i class="fa fa-minus"></i>
												</button>
											</span>
											<input type="text" name="qty[{{$key}}]" class="form-control input-hollow-cart input-number qty pqty" value="{{ $value['qty'] }}" 
												min="0" max="@if(50<=$value['stock']){{ '50' }}@else{{ $value['stock'] }}@endif" 
												data-stock="{{ $value['stock'] }}" data-id="{{ $value['varian_id'] }}" data-name="qty-{{strtolower($value['size'])}}[1]"
												data-oldValue="" data-toggle="tooltip" data-placement="top" @if($value['stock']==0){{'disabled'}}@endif>
											<span class="input-group-btn">
												<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number" data-type="plus" 
												data-field="qty-{{strtolower($value['size'])}}[1]" data-get-flag="qty-{{strtolower($value['size'])}}" 
												data-price="{{ $item_list_normal_price }}" 
												data-action-update="{{ route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key]) }}">
													<i class="fa fa-plus"></i>
												</button>
											</span>
										</div>
									{!! Form::close() !!}   
								</div>
							</div>
						</div>	
					@endforeach
					<div class="row chart-item-mobile">
						<div class="hidden-lg hidden-md hidden-sm col-xs-12">
							<div class="row">
								<div class="col-xs-3">
									<h4>Harga</h4>
								</div>
								<div class="col-xs-1 text-right">
									<h4>:</h4>
								</div>
								<div class="col-xs-8 text-right">
									<label class="m-b-sm label-item m-r-sm">
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
								<div class="col-xs-8 text-right">
									<label class="m-b-sm label-item m-r-sm">
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
								<div class="col-xs-8 text-right">
									<label class="label-item m-r-sm">
										@money_indo($item_list_total_price)
									</label>
								</div>
							</div>
						</div>
					</div>						
				</div>
			</div>
		</div>
	</div>
</div>