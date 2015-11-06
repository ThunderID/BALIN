@inject('data', 'App\Models\ProductUniversal')
@inject('products', 'App\Models\Product')

<?php 
	// $stat 		= $data->id($id)->totalsell(true)->first();
	// $suppliers 	= $data->id($id)->suppliers(true)->first();
	
	$data 		= $data::find($id);

	$products 	= $products::where('product_universal_id', $id);

	if(!is_null($filters) && is_array($filters))
	{
		foreach ($filters as $key => $value) 
		{
			$products = call_user_func([$products, $key], $value);
		}
	}

	$products 	= $products->orderby('name')->paginate();
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
			<h2 style="margin-top:0px;">{{ $data['name'] }}</h2>
			<h5><strong>UPC &nbsp;</strong>{{ $data['upc'] }}</h5>
			<h5><strong>Description &nbsp;</strong>{{ $data['description'] }}</h5>
		</div>	
		<div class="col-md-6">
		</div>	
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Varian Produk
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-sm-4 hidden-xs">
			<a class="btn btn-default" href="{{ URL::route('backend.data.product.create', ['uid' => $data['id'] ]) }}"> Data Baru </a>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<a class="btn btn-default btn-block" href="{{ URL::route('backend.data.product.create', ['uid' => $data['id'] ]) }}"> Data Baru </a>
		</div>
		<div class="col-md-4 col-sm-8 col-xs-12">
			{!! Form::open(['url' => route('backend.data.productuniversal.show', ['uid' => $id] ), 'method' => 'get']) !!}
			<div class="row">
				<div class="col-md-2 col-sm-3 hidden-xs">
				</div>
				<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
					{!! Form::input('text', 'q', Null , [
								'class'         => 'form-control',
								'placeholder'   => 'Cari sesuatu',
								'required'      => 'required',
								'style'         =>'text-align:right'
						]) !!}                                          
				</div>
				<div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
					<button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>  
	</div>
	@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.data.productuniversal.show', ['id' => $data['id']]) ])
	<div class="table-responsive">
		</br>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>SKU</th>
					<th>Nama Produk</th>
					<th>Kontrol</th>
				</tr>
			</thead>
			<tbody>
				@if (count($products) == 0)
					<tr>
						<td colspan="6">
							<p class="text-center">Tidak ada data</p>
						</td>
					</tr>
				@else
					@foreach($products as $ctr => $product)
						<tr>
							<td>{{ $ctr+1 }}</td>
							<td>{{ $product['sku']  }}</td>
							<td>{{ $product['name'] }}</td>
							<td> 
								<a href="{{ route('backend.data.product.show', ['uid' => $id, 'id' => $product['id'] ]) }}"> Detail </a>,
								<a href="{{ route('backend.data.product.edit', ['uid' => $id, 'id' => $product['id'] ]) }}"> Edit </a>,
								
								<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#sc_del"
									data-id="{{$product['id']}}"
									data-title="Hapus Data Ongkos Kirim ">
									Hapus
								</a>   
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>  
@stop