@inject('data', 'App\Models\Product')
<?php 
	$stat 		= $data->id($id)->totalsell(true)->first();
	$suppliers 	= $data->id($id)->suppliers(true)->first();
	// $product 		= $product::id($id)
	// 				->with(['categories', 'images', 'stocks'])
	// 				->first(); 
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Produk
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					@foreach ($product->images as $k => $img)
						@if ($k==5)
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						@endif
						{!! HTML::image($img->image_xs) !!}
					@endforeach
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					@if(isset($stat))
						{!! $stat->selled_stock !!}
					@else
						0
					@endif
				</div>
				<div class="panel-heading">Jumlah Dibeli</div>
			</div>

			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					@if(isset($stat))
						{!! $stat->selled_frequency !!}
					@else
						0
					@endif
				</div>
				<div class="panel-heading">Total Pembelian</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					{!! $product->stock !!}
				</div>
				<div class="panel-heading">Stok Display</div>
			</div>

			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					@if(isset($product->stocks[0]))
						{!! $product->stocks[0]->current_stock + $product->stocks[0]->reserved_stock + $product->stocks[0]->on_hold_stock !!}
					@else
						0
					@endif
				</div>
				<div class="panel-heading">Stok Gudang</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					@if(isset($product->stocks[0]))
						{!! $product->stocks[0]->reserved_stock !!}
					@else
						0
					@endif
				</div>
				<div class="panel-heading">Stok Dibayar</div>
			</div>

			<div class="panel panel-widget panel-default">
				<div class="panel-body">
					@if(isset($product->stocks[0]))
						{!! $product->stocks[0]->on_hold_stock !!}
					@else
						0
					@endif
				</div>
				<div class="panel-heading">Stok Dipesan</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-8">
			<h2 style="margin-top:0px;">{!!$product->name!!}</h2>
			<h5><strong>SKU</strong> {!!$product->sku!!}</h5>
			<h5><strong>Warna</strong> {{$product->color}} </h5>
			<h5><strong>Ukuran</strong> {{$product->size}} </h5>
			<h5>
				<strong>Harga</strong> 
				@if($product->discount!=0)
					<strike> @money_inod($product->price) </strike> 
					@money_indo($product->promo_price)
				@else 
					@money_indo($product->price)
				@endif 
				<span>[ <a href="{{ route('backend.data.product.price.index', ['product_id' => $product['id']]) }}">Histori Harga</a> ]</span>
			</h5> 
			<h5><strong>Diskon</strong> @money_indo($product->discount)</h5>

			<br/>
			<i class = "fa fa-tags"></i>
			@foreach($product->categories as $key => $value)
				@if($key!=0)
					,
				@endif
				{!! $value->name !!}
			@endforeach
			<br/>
			<br/>
			{!!$product->description!!}
		</div>
		<div class="col-md-4">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Daftar Supplier</div>
				<div class="panel-body">
					@if(!is_null($suppliers))
						<ul>
						@foreach($suppliers->transactions as $key => $value)
							<li>
								{!! $value->supplier->name !!}
							</li>
						@endforeach
						</ul>
					@else
						<p class="m-l-sm m-t-sm">Tidak ada supplier</p>
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop