@inject('data', 'App\Models\Category')

<?php $data = $data::where('id', $id)->with('products')->first() ?>

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
							<p class="text-capitalize">{{ $data['name'] }}</p>
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
					<div class="row">
						<div class="col-md-10 text-right">
							<a href="{{ URL::route('backend.category.edit', $data['id']) }}" >Edit</a> 
							|                                                                                  
							<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#category_del"
								data-id="{{$data['id']}}"
								data-title="Hapus Data Kategori {{$data['name']}}">
								Hapus
							</a>                                                                                                               
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</br>

	@include(
		'widgets.pageElements.formModalDelete', [
				'modal_id'      => 'category_del', 
				'modal_route'   => 'backend.category.destroy'
			]
		)

	@if (count($data['products']) == 0)
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-capitalize">Data produk dalam kategori ini</h3>
				 Tidak ada data
				 </br>
				 </br>
			 </div>
		 </div>
	@else
		<div class="table-responsive">
			<h3 class="text-capitalize">Data produk dalam kategori ini</h3>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th class="col-md-3">SKU</th>
						<th class="col-md-7">Nama</th>
						<th>Kontrol</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data['products'] as $ctr => $product)
						<tr>
							<td>{{ $ctr+1 }}</td>
							<td>{{ $product['sku'] }}</td>
							<td>{{ $product['name'] }}</td>
							<td> 
								<a href="{{ route('backend.product.show', $product->id) }}"> Detail </a>,
								<a href="{{ route('backend.product.edit', $product->id) }}"> Edit </a>,
								<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#product_del"
									data-id="{{$product['id']}}"
									data-title="Hapus Data Produk {{$product['name']}}">
									Hapus
								</a>   
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>  

		@include(
			'widgets.pageElements.formModalDelete', [
					'modal_id'      => 'product_del', 
					'modal_route'   => 'backend.product.destroy'
				]
			)      
	@endif         
@stop