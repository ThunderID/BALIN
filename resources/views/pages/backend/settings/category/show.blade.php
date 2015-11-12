@inject('data', 'App\Models\Category')
@inject('td', 'App\Models\TransactionDetail')

<?php 
$data = $data::id($id)->with(['category'])->first();
$frequentbuy  = $td->FrequentBuyByCategory($id)->get();
$mostbuy  = $td->MostBuyByCategory($id)->get();
?>

@extends('template.backend.layout')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="row">
					<h3 class="text-capitalize">Informasi Kategori</h3>
					<div class="row">
						<div class="col-md-4 text-left">
							<p class="text-capitalize">Parent<span class="pull-right">:</span></p>
						</div>
						<div class="col-md-8">
							<p class="text-capitalize">{{ $data['category']['name'] }}</p>
						</div>
					</div>                
					<div class="row">
						<div class="col-md-4 text-left">
							<p class="text-capitalize">Nama Kategori<span class="pull-right">:</span></p>
						</div>
						<div class="col-md-8">
							<p class="text-capitalize">{{ $data['name'] }}</p>
						</div>
					</div> 
					<div class="row">
						<div class="col-md-4 text-left">
							<p class="text-capitalize">Jumlah Produk<span class="pull-right">:</span></p>
						</div>
						<div class="col-md-8">
							<p>{{ count($data['products']) }}</p>
						</div>
					</div>                                                        
				</div>
			</div>
		</div>
	</div>
	</br>

	<div class="row">
		<div class="col-md-6">
			<div class="table-responsive">
				<h3 class="text-capitalize">Produk paling banyak dibeli pada kategori ini</h3>
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th class="col-md-8">Produk</th>
							<th class="col-md-3">Quantitas Pembelian</th>
						</tr>
					</thead>
					<tbody>
						@forelse($mostbuy as $ctr => $product)
							<tr>
								<td>{{ $ctr+1 }}</td>
								<td>{{ $product['product']['name'] }}</td>
								<td>{{ $product['total_buy'] }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="3">Tidak ada produk</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>  
		</div>  
		<div class="col-md-6">
			<div class="table-responsive">
				<h3 class="text-capitalize">Produk paling sering dibeli pada kategori ini</h3>
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th class="col-md-8">Produk</th>
							<th class="col-md-3">Frekuensi Pembelian</th>
						</tr>
					</thead>
					<tbody>
						@forelse($frequentbuy as $ctr => $product)
							<tr>
								<td>{{ $ctr+1 }}</td>
								<td>{{ $product['product']['name'] }}</td>
								<td>{{ $product['frequent_buy'] }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="3">Tidak ada produk</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>  
		</div>  
	</div>  
@stop