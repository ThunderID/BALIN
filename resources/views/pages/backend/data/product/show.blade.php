@inject('data', 'App\Models\Product')
<?php 
	$stat 		= $data->id($id)->totalsell(true)->first();
	$suppliers 	= $data->id($id)->suppliers(true)->first();
	$data 		= $data::id($id)
					->with(['categories', 'images', 'stocks'])
					->first(); 
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
					@foreach ($data->images as $k => $img)
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
			<div class="panel panel-default">
				<div class="panel-heading">Jumlah Dibeli</div>
				<div class="panel-body">
					@if(isset($stat))
						{!! $stat->selled_stock !!}
					@else
						0
					@endif
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Total Pembelian</div>
				<div class="panel-body">
					@if(isset($stat))
						{!! $stat->selled_frequency !!}
					@else
						0
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading">Stok Display</div>
				<div class="panel-body">
					@if(isset($data->stocks[0]))
						{!! $data->stocks[0]->current_stock !!}
					@else
						0
					@endif
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Stok Gudang</div>
				<div class="panel-body">
					@if(isset($data->stocks[0]))
						{!! $data->stocks[0]->current_stock + $data->stocks[0]->reserved_stock + $data->stocks[0]->on_hold_stock !!}
					@else
						0
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading">Stok Dibayar</div>
				<div class="panel-body">
					@if(isset($data->stocks[0]))
						{!! $data->stocks[0]->reserved_stock !!}
					@else
						0
					@endif
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Stok Dipesan</div>
				<div class="panel-body">
					@if(isset($data->stocks[0]))
						{!! $data->stocks[0]->on_hold_stock !!}
					@else
						0
					@endif
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-8">
			<h2 style="margin-top:0px;">{!!$data->name!!}</h2>
			<h5><strong>SKU</strong> {!!$data->sku!!}</h5>
			<h5><strong>Harga</strong> @if($data->discount!=0)<strike> {!!$data->price!!} </strike> {!!$data->promo_price!!} @else {!!$data->price!!} @endif</h5>
			<h5><strong>Diskon</strong> {!!$data->discount!!}</h5>
			@if($data->is_new)
				<label class="label label-danger">New</label><br/>
			@endif
			<br/>
			<i class = "fa fa-tags"></i>
			@foreach($data->categories as $key => $value)
				@if($key!=0)
					,
				@endif
				{!! $value->name !!}
			@endforeach
			<br/>
			<br/>
			{!!$data->description!!}
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
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
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop