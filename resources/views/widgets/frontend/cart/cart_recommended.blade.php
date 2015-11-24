<div class="row">
	<div class="col-xs-12" style="margin:5px;">
		<div class="row">
			<div class="col-xs-3">
				<a href="{{route('frontend.product.show', $label_slug)}}">
					<img class="image-responsive" style="height:80px;width:60px;"  src="{{ $label_image }}" >
				</a>
			</div>
			<div class="col-xs-8">
				<div class="row">
					<div class="col-xs-12">
						<h4 class="m-t-none">
							<a href="{{route('frontend.product.show', $label_slug)}}" class="hover-black" style="text-decoration:none;">
								{{ $label_name }}
							</a>
						</h4>
					</div>
				</div>
				<!-- <div class="row" style="margin-top:0px;">
					<div class="col-xs-12">
						<div class="row">
						@foreach($label_qty as $key => $value)
							<div class="col-xs-4">
								<span class="info">{{ $value['size'] }}</span>
							</div>
						@endforeach
						</div>
					</div>
				</div> -->
				<div class="row" style="margin-top:0px;">
					<div class="col-xs-12">
						<div class="row">
							<div class="col-xs-12">
								@if($label_promo==0)
								<span class="info">@money_indo($label_price)</span>
								@else
								<span class="info">
									<strike>
										@money_indo($label_price)
									</strike>
									<br/>@money_indo($label_promo)
								</span>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>