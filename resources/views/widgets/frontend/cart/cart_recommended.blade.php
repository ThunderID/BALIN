<div class="row recommend-product m-t-sm">
	<div class="col-xs-12" style="margin:5px;">
		<div class="row">
			<div class="col-xs-4">
				<a href="{{route('frontend.product.show', $label_slug)}}">
					<img class="image-responsive m-l-sm" style="height:80px;width:60px;"  src="{{ $label_image }}">
				</a>
			</div>
			<div class="col-xs-8">
				<h4 class="m-t-none">
					<a href="{{route('frontend.product.show', $label_slug)}}" class="link-black hover-grey" style="text-decoration:none;">
						{{ $label_name }}
					</a>
				</h4>
				@if($label_promo==0)
					<span class="text-product">@money_indo($label_price)</span>
				@else
					<span class="text-product small-price">@money_indo($label_price)</span><br>
					<span class="text-product">@money_indo($label_promo)</span>
				@endif
			</div> 
		</div>
	</div>
</div>