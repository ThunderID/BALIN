@inject('data', 'App\Models\Supplier')
@inject('products', 'App\Models\TransactionDetail')
<?php 
	$products 	= $products->supplier($id)->with(['varian.product', 'product'])->get();
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Informasi Supplier
			</h4>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Nama<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p class="text-capitalize">{{ $supplier['name'] }}</p>
				</div>
			</div> 
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Telepon<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p>{!!$supplier['address']['phone']!!}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Alamat<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p>{!!$supplier['address']['address']!!}</p>
					<p>{!!$supplier['address']['zipcode']!!}</p>
				</div>
			</div>
		</div>
	</div>
	</br>

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
			<h4 class="text-capitalize">Produk yang di supply</h4>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th class="col-md-6">Produk</th>
						<th class="col-md-3">Rerata Harga Beli</th>
						<th class="col-md-2">Kontrol</th>
					</tr>
				</thead>
				<tbody>
					@forelse($products as $ctr => $product)
						<tr>
							<td>{{ $ctr+1 }}</td>
							<td>{{ $product['varian']['product']['name'] }} ukuran {{ $product['varian']['size'] }}</td>
							<td class="text-right">@money_indo($product['hb'])</td>
							<td>
								<a href="{{ route('backend.data.product.varian.show', ['pid' => $product['product']['id'], 'id' => $product['varian_id'] ]) }}"> Detail </a>,
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="4" class="text-center">Tidak ada produk</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop