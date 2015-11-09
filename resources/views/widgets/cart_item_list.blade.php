<div class="row chart-item">
	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="row">
			<div class="col-sm-3 col-xs-3">
                <a href="#">
                	<img class="image-responsive" style="height:107px;width:85px;margin-top:5px;"  src="{{ $item_list_image }}" >
                </a>
			</div>
			<div class="col-sm-8 col-xs-8">
 				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h4 style="margin-bottom:3px;">{{ $item_list_name }}</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-xs-12">	
						<p>SKU : {{ $item_list_sku }}</p>
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
								<h4 class="text-right">{{ $item_list_qty}}</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<h4>Price</h4>
							</div>
							<div class="col-xs-1 text-right">
								<h4>:</h4>
							</div>
							<div class="col-xs-7">
								<h4 class="text-right" style="margin-bottom:10px;">
									@money_indo($item_list_normal_price) - 
									@money_indo($item_list_discount_price)
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="col-xs-12" style="border-bottom: 1px solid #ccc; margin-bottom:5px;">
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
							<div class="col-xs-7">
								<h4 class="text-right">@money_indo($item_list_total_price)</h4>
							</div>
						</div>
					</div>
				</div>						
			</div>
		</div>
	</div>
	<div class="col-md-1 col-sm-1 hidden-xs">
		<h4 class="text-center">{{ $item_list_qty }}</h4>
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs">
		@if ($item_list_promo_price!=0)
			<h4 class="text-right">@money_indo($item_list_promo_price)</h4>
		@endif
		<h4 class="text-right">@money_indo($item_list_normal_price)</h4>
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs">
		<h4 class="text-right">@money_indo($item_list_discount_price)</h4>
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs">
		<h4 class="text-right">@money_indo($item_list_total_price)</h4>
	</div>
	<div class="col-md-1 col-sm-1 hidden-xs">
        <button style="margin-top:7px;" type="button" class="btn-hollow btn-hollow-xs hollow-black pull-right">
            <span class="glyphicon glyphicon-remove" style="padding-top:2px;"></span>
        </button></td>	
	</div>
	<div class="hidden-lg hidden-md hidden-sm col-xs-12">
		<div class="row">
			</br>			
			<div class="col-xs-12">
		        <button type="button" class="btn-hollow hollow-black btn-block">
		            <span class="glyphicon glyphicon-remove" style="padding-top:4px;"></span> Remove from Cart
		        </button>						
			</div>
			</br>			
		</div>
		<div class"row">
			</br>
		</div>	
	</div>
</div>