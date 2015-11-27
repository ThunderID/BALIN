<div class="hidden-xs">
	@if($carts[$k]['slug'] != end($carts)['slug'])
		<div class="row chart-item" style="border-bottom: 0.09em solid #ccc">
	@else
		<div class="row chart-item">
	@endif
	
		<div class="col-sm-2 col-md-2 clearfix">
			<a href="{{ route('frontend.product.show', $item_list_slug) }}">
				<img class="img-responsive m-t-sm" src="{{ $item_list_image }}" >
			</a>
		</div>
		<div class="col-sm-10 col-md-10 p-b-sm">
			<div class="row m-b-xs">
				<div class="col-md-12">
					<h4 class="m-b-xs"><a href="{{ route('frontend.product.show', $item_list_slug) }}" class="title">{{ $item_list_name }}</a></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<p class="m-b-sm"><strong>Size</strong></p>
						</div>
					</div>
				</div>
			</div>
			@foreach($item_list_size as $key => $value)
				<div class="row p-b-sm">
					<div class="col-sm-2 col-md-2">
						@if (strpos($value['size'], '.')==true)
							<?php $frac = explode('.', $value['size']); ?>
							{{ $frac[0].' &frac12;'}}
						@else
							{{ $value['size'] }}
						@endif
					</div>
					<div class="col-sm-1 col-md-1 text-center">
						{{ $value['qty'] }}
					</div>
					<div class="col-sm-3 col-md-3 text-right">
						@money_indo($item_list_normal_price)
					</div>
					<div class="col-sm-3 col-md-3 text-right">
						@money_indo($item_list_discount_price) 
					</div>
					<div class="col-sm-3 col-md-3 text-right">
						@money_indo($item_list_total_price)
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>

<div class="hidden-sm hidden-md hidden-lg">
	<div class="row chart-item" style="border-bottom: 0.09em solid #ccc">
		<div class="col-md-12 col-sm-12 col-xs-10 col-xs-offset-1">
			<div class="row">
				<div class="col-sm-2 col-xs-8 col-xs-offset-2">
					 <a href="#">
						<img class="img-responsive m-t-sm" src="{{ $item_list_image }}" >
					 </a>
				</div>
				<div class="col-sm-10 col-xs-12">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<h4 class="m-b-xs" style="font-size:20px; font-weight:300">{{ $item_list_name }}</h4>
							<p class="m-t-sm m-b-sm">Size </p>
						</div>
					</div>
					@foreach($item_list_size as $key => $value)
						<div class="row">
							<div class="col-sm-9 col-xs-3">
								<p class="m-t-xxs m-b-xxs">
									@if (strpos($value['size'], '.')==true)
										<?php $frac = explode('.', $value['size']); ?>
										{{ $frac[0].' &frac12;'}}
									@else
										{{ $value['size'] }}
									@endif
								</p>
							</div>
							<div class="col-xs-8 text-right">
								<label class="m-b-sm label-item m-r-sm">
									{{ $value['qty'] }}
								</label>
							</div>
						</div>
					@endforeach
					<div class="row chart-item-mobile">
						<div class="col-xs-3">
							<h4>Harga</h4>
						</div>
						<div class="col-xs-1 text-right">
							<h4>:</h4>
						</div>
						<div class="col-xs-7 text-right">
							<label class="m-b-sm label-item m-r-sm">
								@money_indo($item_list_normal_price) 
							</label>
						</div>
					</div>
					<div class="row chart-item-mobile">
						<div class="col-xs-3">
							<h4>Diskon</h4>
						</div>
						<div class="col-xs-1 text-right">
							<h4>:</h4>
						</div>
						<div class="col-xs-7 text-right">
							<label class="m-b-sm label-item m-r-sm">
								@money_indo($item_list_discount_price) 
							</label>
						</div>
					</div>
					<div class="row chart-item-mobile">
						<div class="col-xs-12">
							<div class="col-xs-12 m-b-xs" style="border-bottom: 1px solid #ccc;">
							</div>
						</div>
					</div>
					<div class="row chart-item-mobile">
						<div class="col-xs-3 hidden-xs">
							<h4>Total</h4>
						</div>
						<div class="col-xs-1 hidden-xs text-right">
							<h4>:</h4>
						</div>
						<div class="hidden-lg hidden-md hidden-sm col-xs-3">
							&nbsp;
						</div>
						<div class="hidden-lg hidden-md hidden-sm col-xs-1">
							&nbsp;
						</div>						
						<div class="col-xs-7 text-right">
							<label class="label-item m-r-sm">
								@money_indo($item_list_total_price)
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix hidden-xs">&nbsp;</div>
</div>
					


					{{-- <div class="row chart-item-mobile m-t-sm">
						<div class="hidden-lg hidden-md hidden-sm col-xs-12">
							<div class="row">
								<div class="col-xs-3">
									<h4>Harga</h4>
								</div>
								<div class="col-xs-1 text-right">
									<h4>:</h4>
								</div>
								<div class="col-xs-7 text-right">
									<label class="m-b-sm label-item">
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
									<label class="m-b-sm label-item">
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
									<label class="label-item">
										@money_indo($item_list_total_price)
									</label>
								</div>
							</div>
						</div>
					</div>						
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-3 hidden-xs text-right">
			<label class="m-t-lg label-item">@money_indo($item_list_normal_price)</label>
		</div>
		<div class="col-md-3 col-sm-3 hidden-xs text-right">
			<label class="m-t-lg label-item">@money_indo($item_list_total_price)</label>
		</div>
	</div>
</div>
<div class="hidden-sm hidden-md hidden-lg">

</div> --}}