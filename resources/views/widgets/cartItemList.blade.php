<div class="row chart-item">
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="row">
			<div class="col-sm-3 col-xs-3">
                <a href="#">
                	<img class="image-responsive" style="height:107px;width:85px;margin-top:5px;"  src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" >
                </a>
			</div>
			<div class="col-sm-8 col-xs-8">
 				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h4 style="margin-bottom:3px;">{{$itemListName}}</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-xs-12">	
						<p>SKU : {{$ItemListSku}}</p>
					</div>
				</div>	
				<div class="row">
			        @include('widgets.particle.labelCategory', array("labelTitle" => "Ukuran", "labelValue" => "M"))
			        @include('widgets.particle.labelCategory', array("labelTitle" => "Warna", "labelValue" => "Merah"))
			        @include('widgets.particle.labelCategory', array("labelTitle" => "Motif", "labelValue" => "Floral"))
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
								<h4 class="text-right">{{$itemListQty}}</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<h4>Price (Rp)</h4>
							</div>
							<div class="col-xs-1 text-right">
								<h4>:</h4>
							</div>
							<div class="col-xs-7">
								<h4 class="text-right" style="margin-bottom:10px;">{{$itemListNormalPrice}} - {{$itemListDiscountPrice}}</h4>
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
								<h4>Total (Rp)</h4>
							</div>
							<div class="col-xs-1 text-right">
								<h4>:</h4>
							</div>
							<div class="col-xs-7">
								<h4 class="text-right">{{$itemListTotalPrice}}</h4>
							</div>
						</div>
					</div>
				</div>						
			</div>
		</div>
	</div>
	<div class="col-md-1 col-sm-1 hidden-xs">
		<h4 class="text-center">{{$itemListQty}}</h4>
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs">
		<h4 class="text-right">{{$itemListNormalPrice}}</h4>
		<h4 class="text-right">{{$itemListDiscountPrice}}</h4>
	</div>
	<div class="col-md-2 col-sm-2 hidden-xs">
		<h4 class="text-right">{{$itemListTotalPrice}}</h4>
	</div>
	<div class="col-md-1 col-sm-1 hidden-xs">
        <button style="margin-top:7px;" type="button" class="btn btn-xs btn-default pull-right">
            <span class="glyphicon glyphicon-remove" style="padding-top:4px;"></span>
        </button></td>	
	</div>
	<div class="hidden-lg hidden-md hidden-sm col-xs-12">
		<div class="row">
			</br>			
			<div class="col-xs-12">
		        <button type="button" class="btn btn-default btn-block">
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