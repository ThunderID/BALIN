<div class="hidden-xs">
	<div class="row chart-item border-bottom">
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
							<a href="{{ route('frontend.product.show', $item_list_slug) }}" class="title link-black hover-grey"><h4 class="m-b-xs">{{ $item_list_name }}</h4></a>
							<!-- <p class="m-b-sm">
								<a href="#" class="link-grey hover-black unstyle ltr-space-08 btn-delete-item" data-vid="{{ $key }}" data-cid="{{ $item_list_id }}" data->
									<i class="fa fa-times-circle"></i> Hapus Item
								</a>
							</p> -->
							<p class="m-b-sm"><strong>Size</strong></p>
						</div>
					</div>
				</div>
				<div class="col-sm-8 col-md-8">&nbsp;</div>
			</div>
			@foreach($item_list_size as $key => $value)
				<div class="row list-vid" data-vid="{{ $key }}" data-cid="{{ $item_list_id }}">
					<div class="col-sm-2 col-md-3 qty-{{strtolower($value['size'])}}" data-get-flag="qty-{{strtolower($value['size'])}}">
						<div class="row">
							<div class="col-sm-7 col-md-4 p-r-none">
								<p class="m-b-none" style="line-height:20px">
									@if (strpos($value['size'], '.')==true)
										<?php $frac = explode('.', $value['size']); ?>
										{{ $frac[0].' &frac12;'}}
									@else
										{{ $value['size'] }}
									@endif
								</p>
							</div>
							<div class="col-sm-5 col-md-8 p-l-none">
								<!-- <a href="javascript:void(0);" data-action="{{ route('frontend.cart.destroy', ['cid' => $item_list_id, 'vid' => $key] ) }}" data-cid="{{ $item_list_id }}" data-vid="{{ $key }}" data-field="qty-{{strtolower($value['size'])}}[1]"  class="btn-delete-varian t-xs link-grey hover-black unstyle">(Batal)</a> -->
							</div>
						</div>
					</div>
					
					<div class="col-sm-3 col-md-3 text-center qty-{{strtolower($value['size'])}}" data-get-flag="qty-{{strtolower($value['size'])}}">
						<div class="row qty-hollow-cart">
							{!! Form::open(['url' => route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key] ), 'method' => 'POST', 'class' => 'form-cart']) !!}
								{!! Form::hidden('cid', $item_list_id, ['class' => 'cid']) !!}
								{!! Form::hidden('vid', $key, ['class' => 'vid']) !!}
								<input type="hidden" name="varianids[{{$key}}]" class="form-control" value="{{$value['varian_id']}}">
								<div class="col-sm-4 col-md-4 text-right p-r-none" style="z-index:1">
									<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number" 
										data-vid="{{ $key }}" data-cid="{{ $item_list_id }}"
										@if($value['qty'] <= 0)disabled="disabled"@endif data-type="minus" data-field="qty-{{strtolower($value['size'])}}[1]" 
										data-get-flag="qty-{{strtolower($value['size'])}}" data-price="{{ $item_list_normal_price }}" 
										data-action-update="{{ route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key]) }}">
										<i class="fa fa-minus"></i>
									</button>
								</div>
								<div class="col-sm-4 col-md-4 p-l-none p-r-none m-r-n-sm m-l-n-sm">
									<div class="form-group">
										<input type="text" name="qty[{{$key}}]" class="form-control input-hollow-cart input-number qty pqty" 
										style="width:100%"
										value="{{ $value['qty'] }}" 
										min="0" max="@if(50<=$value['stock']){{ '50' }}@else{{ $value['stock'] }}@endif" 
										data-stock="{{ $value['stock'] }}" 
										data-id="{{ $value['varian_id'] }}" 
										data-name="qty-{{strtolower($value['size'])}}[1]"
										data-cid="{{ $item_list_id }}"
										data-id="{{ $value['varian_id'] }}" 
										data-name="qty-{{strtolower($value['size'])}}[1]"
										data-oldValue="" 
										data-price="{{ $item_list_normal_price }}"
										data-discount="{{ $item_list_discount_price }}"
										data-total="{{ (($item_list_normal_price-$item_list_discount_price)*$value['qty']) }}" 
										data-subtotal="{{ $item_list_total_price }}" >
									</div>
								</div>
								<div class="col-sm-4 col-md-4 text-left p-l-none">
									<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number" data-type="plus" 
									data-vid="{{ $key }}" data-cid="{{ $item_list_id }}"
									data-field="qty-{{strtolower($value['size'])}}[1]" data-get-flag="qty-{{strtolower($value['size'])}}" 
									data-price="{{ $item_list_normal_price }}" 
									data-action-update="{{ route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key]) }}"
									@if($value['qty'] >= $value['stock'])disabled="disabled"@endif>
										<i class="fa fa-plus"></i>
									</button>
								</div>
							{!! Form::close() !!}   
						</div>
					</div>
					<div class="col-sm-2 col-md-2 text-right p-l-none label-price qty-{{strtolower($value['size'])}}" data-price="{{ $item_list_normal_price }}" 
						data-get-price="qty-{{strtolower($value['size'])}}" data-get-flag="qty-{{strtolower($value['size'])}}">
						@money_indo($item_list_normal_price)
					</div>
					<div class="col-sm-2 col-md-2 text-right qty-{{strtolower($value['size'])}}" data-get-flag="qty-{{strtolower($value['size'])}}">
						@money_indo($item_list_discount_price) 
					</div>
					<div class="col-sm-3 col-md-2 text-right label-total qty-{{strtolower($value['size'])}}" 
						data-total="{{ ($item_list_normal_price - $item_list_discount_price) * $value['qty'] }}" data-get-total="qty-{{strtolower($value['size'])}}" 
						data-get-flag="qty-{{strtolower($value['size'])}}" data-subtotal="{{ $item_list_total_price }}">
						<span>
							@money_indo(($item_list_normal_price-$item_list_discount_price)*$value['qty'])
						</span>
						<div class="clearfix">&nbsp;</div>	
						<div class="clearfix">&nbsp;</div>
					</div>	
				</div>
			@endforeach
		</div>
	</div>
</div>
<div class="hidden-sm hidden-md hidden-lg">
	<div class="row chart-item">
		<div class="col-md-12 col-sm-12 col-xs-10 col-xs-offset-1">
			<div class="row">
				<div class="col-sm-2 col-xs-8 col-xs-offset-2">
					 <a href="#">
						<img class="img-responsive m-t-sm" src="{{ $item_list_image }}" style="border:1px solid #eee">
					 </a>
				</div>
				<div class="col-sm-10 col-xs-12">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<a href="{{ route('frontend.product.show', $item_list_slug) }}" class="title link-black hover-grey"><h4 class="m-b-xs">{{ $item_list_name }}</h4></a>
							<p class="m-t-sm m-b-sm"><strong>Size : </strong></p>
						</div>
					</div>
					@foreach($item_list_size as $key => $value)
						<div class="row m-b-md list-vid-mobile" data-vid="{{ $key }}" data-cid="{{ $item_list_id }}">
							<div class="col-xs-3">
								<p class="m-t-xxs m-b-xxs">
									@if (strpos($value['size'], '.')==true)
										<?php $frac = explode('.', $value['size']); ?>
										{{ $frac[0].' &frac12;'}}
									@else
										{{ $value['size'] }}
									@endif
								</p>
							</div>
							<div class="col-xs-3">
								<!-- <a href="javascript:void(0);" data-action="{{ route('frontend.cart.destroy', ['cid' => $item_list_id, 'vid' => $key] ) }}" data-cid="{{ $item_list_id }}" data-vid="{{ $key }}" data-field="qty-{{strtolower($value['size'])}}[1]"  class="btn-delete-varian">(Batal)</a> -->
							</div>
							<div class="col-xs-2">&nbsp;</div>
							{!! Form::open(['url' => route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key] ), 'method' => 'POST', 'class' => 'form-cart']) !!}
								{!! Form::hidden('cid', $item_list_id, ['class' => 'cid']) !!}
								{!! Form::hidden('vid', $key, ['class' => 'vid']) !!}
								<div class="col-xs-1 p-r-none qty-hollow-cart">
									<button type="button" class="btn-hollow btn-block btn-hollow-sm btn-hollow-cart btn-number-mobile pull-right" 
										@if($value['qty'] <= 0)disabled="disabled"@endif data-type="minus" data-field="qty-{{strtolower($value['size'])}}[1]" 
										data-get-flag="qty-{{strtolower($value['size'])}}" data-price="{{ $item_list_normal_price }}" 
										data-vid="{{ $key }}" data-cid="{{ $item_list_id }}"
										data-action-update="{{ route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key]) }}" >
										<i class="fa fa-minus"></i>
									</button>
								</div>
								<div class="col-xs-1 qty-hollow-cart" style="padding-left: 0px; padding-right: 0px;">
									<div class="form-group">
										<input type="number" name="qty[{{$key}}]" style="width:100%;border-radius:0" class="form-control input-hollow-cart text-center input-number-mobile qty pqty-mobile" value="{{ $value['qty'] }}" 
										min="0" max="@if(50<=$value['stock']){{'50'}}@else{{ $value['stock'] }}@endif" 
										data-stock="{{ $value['stock'] }}" 
										data-cid="{{ $item_list_id }}"
										data-id="{{ $value['varian_id'] }}" 
										data-name="qty-{{strtolower($value['size'])}}[1]"
										data-oldValue="{{ $value['qty'] }}" 
										data-price="{{ $item_list_normal_price }}"
										data-discount="{{ $item_list_discount_price }}"
										data-total="{{ (($item_list_normal_price-$item_list_discount_price)*$value['qty']) }}" 
										data-subtotal="{{ $item_list_total_price }}" 
										 @if($value['stock']==0){{'disabled'}}@endif>
									</div>	
								</div>	
								<div class="col-xs-1 p-l-none qty-hollow-cart">
									<button type="button" class="btn-hollow btn-hollow-sm btn-hollow-cart btn-number-mobile pull-left" data-type="plus" 
									data-vid="{{ $key }}" data-cid="{{ $item_list_id }}"
									data-field="qty-{{strtolower($value['size'])}}[1]" data-get-flag="qty-{{strtolower($value['size'])}}" 
									data-price="{{ $item_list_normal_price }}" 
									data-action-update="{{ route('frontend.cart.update', ['cid' => $item_list_id, 'vid' => $key]) }}"
									@if($value['qty'] >= $value['stock'])disabled="disabled"@endif >
										<i class="fa fa-plus"></i>
									</button>
								</div>
								<input type="hidden" name="varianids[{{$key}}]" class="form-control" value="{{$value['varian_id']}}">
							{!! Form::close() !!}   
						</div>	
					@endforeach
					<div class="row chart-item-mobile">
						<div class="hidden-lg hidden-md hidden-sm col-xs-12">
							<div class="row m-b-xs">
								<div class="col-xs-4">
									<label class="label-caption">Harga</label>
								</div>
								<div class="col-xs-7 text-right">
									<label class="label-item">
										@money_indo($item_list_normal_price) 
									</label>
								</div>
							</div>
							<div class="row m-b-xs">
								<div class="col-xs-4">
									<label class="label-caption">Diskon</label>
								</div>
								<div class="col-xs-7 text-right">
									<label class="label-item">
										@money_indo($item_list_discount_price) 
									</label>
								</div>
							</div>
							<div class="row m-b-xs">
								<div class="col-xs-12">
									<div class="col-xs-12 " style="border-bottom: 1px solid #ccc;">
									</div>
								</div>
							</div>
							<div class="row m-t-sm">
								<div class="col-xs-4">
								</div>
								<div class="col-xs-7 text-right">
									<label class="label-item label-total-mobile" data-subtotal="{{ $item_list_total_price }}">
										@money_indo($item_list_total_price)
									</label>
								</div>
								<div class="col-xs-1">&nbsp;</div>
							</div>
						</div>
					</div>						
					<div class="row">
						<div class="col-xs-12">
							<a href="#" class="btn-hollow hollow-black-border-transaparent btn-block m-t-md font-weight-300 ltr-space-08 btn-delete-item"
								data-vid="{{ $key }}" data-cid="{{ $item_list_id }}">
								HAPUS ITEM
							</a>
						</div>
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>