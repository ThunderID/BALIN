@inject('product', 'App\Models\Product')
@inject('data', 'App\Models\Varian')
@inject('td', 'App\Models\TransactionDetail')

<?php 
	$product 		= $product::find($pid);

	$data 			= $data::find($id);

	$td 			= $td->varianid($id)->CountSoldItemByProduct(true);
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
			<h2 style="margin-top:0px;">{{ $product['name'] }} - {{ $data['size'] }}</h2>
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
		<div class="col-md-2">
			<div class="panel panel-panel panel-default">
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						{!! $data->stock !!}
					</h4>
				</div>
				<div class="panel-heading">Stok Display</div>
			</div>
		</div>

		<div class="col-md-2">
			<div class="panel panel-panel panel-default">
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if(isset($data->stocks[0]))
							{!! $data->stocks[0]->current_stock + $data->stocks[0]->reserved_stock + $data->stocks[0]->on_hold_stock !!}
						@else
							0
						@endif
					</h4>
				</div>
				<div class="panel-heading">Stok Gudang</div>
			</div>
		</div>

		<div class="col-md-2">
			<div class="panel panel-panel panel-default">
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if(isset($data->stocks[0]))
							{!! $data->stocks[0]->reserved_stock !!}
						@else
							0
						@endif
					</h4>
				</div>
				<div class="panel-heading">Stok Dibayar</div>
			</div>
		</div>

		<div class="col-md-2">
			<div class="panel panel-panel panel-default">
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if(isset($data->stocks[0]))
							{!! $data->stocks[0]->on_hold_stock !!}
						@else
							0
						@endif
					</h4>
				</div>
				<div class="panel-heading">Stok Dipesan</div>
			</div>
		</div>		

		<div class="col-md-2">
			<div class="panel panel-panel panel-default">
				<div class="panel-body">
					<h4 class="m-r-sm m-t-sm text-right">
						@if(isset($data->stocks[0]))
							{!! $data->stocks[0]->on_hold_stock !!}
						@else
							0
						@endif
					</h4>
				</div>
				<div class="panel-heading">Sold Items</div>
			</div>
		</div>	

	</div>
	<div class="row border-bottom white-bg dashboard-header"></div>
@stop