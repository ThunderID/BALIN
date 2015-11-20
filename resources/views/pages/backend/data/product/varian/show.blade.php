@inject('product', 'App\Models\Product')
@inject('data', 'App\Models\Varian')
@inject('trsd', 'App\Models\TransactionDetail')

<?php 
	$product 		= $product::find($pid);

	$stocks			= $data::where('varians.id', $id)->globalstock(true)->first();

	$data 			= $data::find($id);

	$td 			= $trsd->varianid($id)->CountSoldItemByProduct(true);

	$cart			= $data::where('varians.id', $id)->quantityincart(true)->first();
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Varian
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h2 style="margin-top:0px;">{{ $product['name'] }} - Ukuran {{ $data['size'] }}</h2>
			<h5><strong>SKU &nbsp;</strong>{{ $data['sku'] }}</h5>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>

	<div class="row">
		<div class="col-md-12">
			<h5><strong>Statistics &nbsp;</strong></h5>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Stok Display</div>
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if($stocks['current_stock'])
							{!! $stocks['current_stock'] !!}
						@else
							0
						@endif
					</h4>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Stok Gudang</div>
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if($stocks['inventory_stock'])
							{!! $stocks['inventory_stock'] !!}
						@else
							0
						@endif
					</h4>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Stok Dibayar</div>
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if($stocks['reserved_stock'])
							{!! $stocks['reserved_stock'] !!}
						@else
							0
						@endif						
					</h4>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Stok Dipesan</div>
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if($stocks['on_hold_stock'])
							{!! $stocks['on_hold_stock'] !!}
						@else
							0
						@endif						
					</h4>
				</div>
			</div>
		</div>		

		<div class="col-md-4">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Sold Items</div>
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if($td['sold_item'])
							{!! $td['sold_item'] !!}
						@else
							0
						@endif						
					</h4>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-list panel-default">
				<div class="panel-heading">Di Keranjang</div>
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if($cart['cart_item'])
							{!! $cart['cart_item'] !!}
						@else
							0
						@endif						
					</h4>
				</div>
			</div>
		</div>
	</div>
@stop