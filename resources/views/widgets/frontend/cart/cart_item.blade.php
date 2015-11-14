<div class="row">
	<div class="col-xs-12" style="margin:5px;">
		<div class="row">
			<div class="col-xs-3">
				<a href="#">
					<img class="image-responsive" style="height:80px;width:60px;"  src="{{ $label_image }}" >
				</a>
			</div>
			<div class="col-xs-8">
				<div class="row">
					<div class="col-xs-12">
						<h4 class="m-t-none">{{ $label_name }}</h4>
					</div>
				</div>
				<div class="row" style="margin-top:0px;">
					<div class="col-xs-12">
						@foreach($label_qty as $key => $value)
						<div class="row">
							<div class="col-xs-4">
								<span class="info">{{ $value['size'] }}</span>
							</div>
							<div class="col-xs-1">
								<span class="info">:</span>
							</div>
							<div class="col-xs-6" style="padding-left: 2px;">
								<span class="info">{{ $value['qty'] }}</span>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div class="row" style="margin-top:0px;">
					<div class="col-xs-12">
						<div class="row">
							<div class="col-xs-4">
								<span class="info">Harga/Item</span>
							</div>
							<div class="col-xs-1">
								<span class="info">:</span>
							</div>
							<div class="col-xs-6" style="padding-left: 2px;">
								<span class="info">@money_indo($label_price)</span>
							</div>                                                                                                                
						</div>                                                    
					</div>
				</div>                                                    
				<div class="row" style="margin-top:0px;">
					<div class="col-xs-12"> 
						<div class="row">
							<div class="col-xs-4">
								<span class="info">Total</span>
							</div>
							<div class="col-xs-1">
								<span class="info">:</span>
							</div>
							<div class="col-xs-6" style="padding-left: 2px;">
								<span class="info">@money_indo($label_total)</span>
							</div>
						</div>                                             
					</div>
				</div>
			</div> 
		</div>
	</div>                                                                                                                       
</div>