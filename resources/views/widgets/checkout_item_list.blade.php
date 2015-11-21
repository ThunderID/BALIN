<div class="row chart-item">
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="row">
			<div class="col-sm-5 col-xs-3">
				 <a href="#">
					<img class="img-responsive m-t-sm" src="{{ $item_list_image }}" >
				 </a>
			</div>
			<div class="col-sm-7 col-xs-8">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h4 class="m-b-xs">{{ $item_list_name }}</h4>
						<p class="m-t-sm m-b-sm">Size :</p>
					</div>
				</div>
				@foreach($item_list_size as $key => $value)
					<div class="row">
						<div class="col-sm-3 col-xs-3">
							<p class="m-t-xxs m-b-xxs">{{ $value['size'] }}</p>
						</div>
						<div class="col-sm-3 col-xs-3">
							<p class="m-t-xxs m-b-xxs">{{ $value['qty'] }}</p>
						</div>
					</div>	
				@endforeach
				<div class="row chart-item-mobile m-t-sm">
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