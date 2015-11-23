@inject('data', 'App\Models\Tag')
@inject('td', 'App\Models\TransactionDetail')

<?php 
$data = $data::id($id)->with(['category'])->first();
$frequentbuy  = $td->FrequentBuyByCategory($id)->get();
$mostbuy  = $td->MostBuyByCategory($id)->get();
$frequentbuybycustomer  = $td->FrequentBuyByCustomerInCategory($id)->get();
$mostbuybycustomer  = $td->MostBuyByCustomerInCategory($id)->get();
?>

@extends('template.backend.layout')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Informasi Tag
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
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
					<p class="text-capitalize">Nama tag<span class="pull-right">:</span></p>
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
	</br>

	<div class="row">
		<div class="col-md-6">
			<div class="table-responsive">
				<h4 class="text-capitalize">Produk paling banyak dibeli pada tag ini</h4>
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
				<h4 class="text-capitalize">Produk paling sering dibeli pada tag ini</h4>
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

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-md-6">
			<div class="table-responsive">
				<h4 class="text-capitalize">Pelanggan paling banyak membeli pada tag ini</h4>
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th class="col-md-8">Pelanggan</th>
							<th class="col-md-3">Quantitas Pembelian</th>
						</tr>
					</thead>
					<tbody>
						@forelse($mostbuybycustomer as $ctr => $user)
							<tr>
								<td>{{ $ctr+1 }}</td>
								<td>{{ $user['user_name'] }}</td>
								<td>{{ $user['total_buy'] }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="3">Tidak ada pelanggan</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>  
		</div>  
		<div class="col-md-6">
			<div class="table-responsive">
				<h4 class="text-capitalize">Pelanggan paling sering membeli pada tag ini</h4>
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th class="col-md-8">Pelanggan</th>
							<th class="col-md-3">Frekuensi Pembelian</th>
						</tr>
					</thead>
					<tbody>
						@forelse($frequentbuybycustomer as $ctr => $user)
							<tr>
								<td>{{ $ctr+1 }}</td>
								<td>{{ $user['user_name'] }}</td>
								<td>{{ $user['frequent_buy'] }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="3">Tidak ada pelanggan</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>  
		</div>  
	</div>  
@stop