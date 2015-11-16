<div class="row chart-item">
	<div class="col-md-1 clearfix">
		<a href="#">
			<img class="image-responsive m-t-sm" style="width:65px;"  src="{{ $item_list_image }}" >
		</a>
	</div>
	<div class="col-md-11">
		<div class="row">
			<div class="col-md-4">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h4 class="m-b-xs">{{ $item_list_name }}</h4>
					</div>
				</div>		
			</div>	
			<div class="col-md-7">
			</div>
			<div class="col-md-1">
				<a href="{{ route('frontend.cart.destroy', $item_list_id) }}" class="btn-hollow btn-hollow-xs hollow-black pull-right m-t-sm">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		<div class="row clearfix">
			&nbsp;
		</div>
		<div class="row">
			@foreach($item_list_size as $key => $value)
				<div class="col-md-4">
					<p>Size : {{ $value['size'] }} <a href="{{ route('frontend.cart.destroy', ['cid' => $item_list_id, 'vid' => $key] ) }}">(Hapus)</a></p>
				</div>
				<div class="col-md-1 text-center">
					{!! Form::text( $k  . '[]', $value['qty'], [
								'class'         => 'form-control text-center', 
								'tabindex'      => '1',
					]) !!}					
				</div>
				<div class="col-md-2 text-right">
					@money_indo($item_list_normal_price) 
				</div>
				<div class="col-md-2 text-right">
					@money_indo($item_list_discount_price) 
				</div>
				<div class="col-md-2 text-right">
					@money_indo(($item_list_normal_price - $item_list_discount_price) * $value['qty'])
				</div>					
				<div class="col-md-1">
					</br>
					</br>
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

