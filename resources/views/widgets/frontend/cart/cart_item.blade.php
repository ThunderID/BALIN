<div class="row">
	<div class="col-xs-12" style="margin:5px;">
		<div class="row">
			<div class="col-xs-3">
				<a href="{{ route('frontend.product.show', $item['slug']) }}">
					<img class="image-responsive" style="height:80px;width:60px;z-index:-1;"  src="{{ $label_image }}" >
				</a>
			</div>
			<div class="col-xs-8">
				<div class="row">
					<div class="col-xs-12">
						<h4 class="m-t-none">
							<a href="{{ route('frontend.product.show', $item['slug']) }}" class="link-black hover-black unstyle">
								{{ $label_name }}
							</a>
						</h4>							
					</div>
				</div>
				<div class="row" style="margin-top:0px;">
					<div class="col-xs-12 m-b-xs">
						<span class="info"><strong>Size</strong></span>
					</div>
					<div class="col-xs-12">
						@foreach($label_qty as $key => $value)
						<div class="row">
							<div class="col-xs-2">
								<span class="info">
									@if (strpos($value['size'], '.')==true)
										<?php $frac = explode('.', $value['size']); ?>
										{{ $frac[0].'&frac12;'}}
									@else
										{{ $value['size'] }}
									@endif
								</span>
							</div>
							<div class="col-xs-1">
								<span class="info">:</span>
							</div>
							<div class="col-xs-8 text-right" style="padding-left: 2px;">
								<span class="info">{{ $value['qty'] }}</span>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div class="row" style="margin-top:0px;">
					<div class="col-xs-12">
						<div class="row">
							<div class="col-xs-2">
								<span class="info">@</span>
							</div>
							<div class="col-xs-1">
								<span class="info">:</span>
							</div>
							<div class="col-xs-8 text-right" style="padding-left: 2px;">
								<span class="info">@money_indo($label_price)</span>
							</div>                                                                                                                
						</div>                                                    
					</div>
				</div>                                                    
				<div class="row" style="margin-top:0px;">
					<div class="col-xs-12"> 
						<div class="row">
							<div class="col-xs-2">
								<span class="info">Total</span>
							</div>
							<div class="col-xs-1">
								<span class="info">:</span>
							</div>
							<div class="col-xs-8 text-right" style="padding-left: 2px;">
								<span class="info">@money_indo($label_total)</span>
							</div>
						</div>                                             
					</div>
				</div>
			</div> 
		</div>
	</div>                                                                                                                       
</div>