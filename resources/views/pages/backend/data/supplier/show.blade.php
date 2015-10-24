@inject('data', 'App\Models\Supplier')
@inject('products', 'App\Models\TransactionDetail')
<?php 
	$data 		= $data::id($id)
					->first(); 
	$products 	= $products->supplier($id)->with(['product'])->get();
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Supplier
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h2 style="margin-top:0px;">{!!$data->name!!}</h2>
			<h5><strong>No. Telp</strong> {!!$data->phone!!}</h5>
			<h5><strong>Alamat</strong> {!!$data->address!!}</h5>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Daftar Produk</div>
				<div class="panel-body">
					<ul>
					@foreach($products as $key => $value)
						<li>
							{!! $value->product->name !!}
						</li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop