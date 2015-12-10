@inject('data', 'App\Models\Product')
@inject('products', 'App\Models\Varian')
@inject('store', 'App\Models\StoreSetting')

<?php 
	$stock		= $store->ondate('now')->type('critical_stock')->first();
	$suppliers 	= $data->where('products.id', $id)->suppliers(true)->get();
	$stocks 	= $data::id($id)->globalstock(true)->first();
	$data 		= $data::where('products.id', $id)->first();

	$lables		= $data['lables'];


	$products 	= $products::where('product_id', $id);

	if(!is_null($filters) && is_array($filters))
	{
		foreach ($filters as $key => $value) 
		{
			$products = call_user_func([$products, $key], $value);
		}
	}

	$products 	= $products->leftglobalstock(true)->orderby('size')->paginate();
?>


@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Campaign
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-10">
					<!-- <h5><strong>Galery</strong></h5> -->
				</div>
				<div class="col-md-2">
					<a href="javascript:clickNext();"><i class="fa fa-angle-right fa-lg pull-right"></i></a>
					&nbsp;
					<a href="javascript:clickPrev();"><i class="fa fa-angle-left fa-lg pull-right"></i></a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="backend-owl-carousel gallery-product">
						@foreach ($data->images as $i => $img)
							<img class="img img-responsive canvasSource hidden galery" src="{{$img['image_xs']}}" alt="">
						@endforeach
					</div>
				</div>
			</div>
			
		</div>	

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h2 style="margin-top:0px;">{{ $data['name'] }}</h2>
					<h5>
						<strong>Harga</strong> 
						@if($data->discount!=0)
							<strike> @money_indo($data->price) </strike> 
							@money_indo($data->promo_price)
						@else 
							@money_indo($data->price)
						@endif 
						<span>[ <a href="{{ route('backend.data.product.price.index', ['pid' => $data['id']]) }}">Histori Harga</a> ]</span>
					</h5> 
					<h5><strong>Diskon</strong> @money_indo($data->discount)</h5>
					<h5><strong>Label &nbsp;</strong>
						@foreach($lables as $lable)
			                <label class="label label-success">{{ str_replace('_', ' ', ucfirst($lable['lable'] ) )}}</label> &nbsp;
						@endforeach
					</h5>
					</br>
					<h5>
						<i class = "fa fa-folder"></i>
						@foreach($data->categories as $key => $value)
							@if($key!=0)
								,
							@endif
							<a href="{{route('backend.settings.category.show', $value['id'])}}">{!! $value['name'] !!}</a>
						@endforeach
						<br/>
						<br/>
						<i class = "fa fa-tags"></i>
						@foreach($data->tags as $key => $value)
							@if($key!=0)
								,
							@endif
							<a href="{{route('backend.settings.tag.show', $value['id'])}}">{!! $value['name'] !!}</a>
						@endforeach
					</h5>			
					</br>
					<?php $product = json_decode($data['description'], true);?>
					<!-- <div class="row">
						<div class="col-md-12">
							<h5><strong>Deskripsi &nbsp;</strong></h5>{!! $product['description'] !!}
						</div>
					</div>
					</br>
					<div class="row">
						<div class="col-md-12">
							<h5><strong>Ukuran & Fit &nbsp;</strong></h5>{!! $product['fit'] !!}
						</div>
					</div> -->
				</div>	
			</div>	
		</div>	
	</div>	

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Stok [UPC {{$data['upc']}}]
			</h4>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3">
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

				<div class="col-md-3">
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

				<div class="col-md-3">
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

				<div class="col-md-3">
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
			</div>		
			<div class="row">
				<div class="col-md-12">
					<h4 class="sub-header">
						Varian Produk  <small><a href="{{ URL::route('backend.data.product.varian.create', ['uid' => $data['id'] ]) }}"> Ukuran Lain </a></small>
					</h4>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-md-6 hidden-xs">
					<a class="btn btn-default" href="{{ URL::route('backend.data.product.varian.create', ['uid' => $data['id'] ]) }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ URL::route('backend.data.product.varian.create', ['uid' => $data['id'] ]) }}"> Data Baru </a>
				</div>
				<div class="col-md-6 col-xs-12">
					{!! Form::open(['url' => route('backend.data.product.show', ['uid' => $id] ), 'method' => 'get']) !!}
					<div class="row">
						<div class="col-md-2 col-sm-3 hidden-xs">
						</div>
						<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
							{!! Form::input('text', 'q', Null , [
										'class'         => 'form-control',
										'placeholder'   => 'Cari sesuatu',
										'required'      => 'required',
															]) !!}                                          
						</div>
						<div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
							<button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>  
			</div> -->
			<!-- @include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.data.product.show', ['id' => $data['id']]) ]) -->
			<div class="table-responsive">
				</br>
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Ukuran</th>
							<th class="text-center">Stok Display</th>
							<th class="text-center">Stok Gudang</th>
							<th class="text-center">Stok Dibayar</th>
							<th class="text-center">Stok Dipesan</th>
							<th class="text-center">Kontrol</th>
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
									<td class="text-center">{{ $ctr+1 }}</td>
									<td class="text-left">{{ $product['size'] }} <br/> [SKU {{ $product['sku']  }}]</td>
									<td class="text-right">{{ $product['current_stock'] }}
										@if($product['current_stock'] < $stock->value && $data->varians()->count())
										<br/>
										<a href="{{ route('backend.data.transaction.create', ['type' => 'buy']) }}">Stok Barang</a>
										@endif
									</td>
									<td class="text-right">{{ $product['inventory_stock'] }}</td>
									<td class="text-right">{{ $product['reserved_stock'] }}</td>
									<td class="text-right">{{ $product['on_hold_stock'] }}</td>
									<td class="text-center"> 
										<a href="{{ route('backend.data.product.varian.show', ['pid' => $id, 'id' => $product['id'] ]) }}"> Detail</a>,
										<a href="{{ route('backend.data.product.varian.edit', ['pid' => $id, 'id' => $product['id'] ]) }}"> Edit</a>,
										
										<a href="javascript:void(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#var_del"
											data-id="{{$data['id']}}"
											data-title="Hapus Data Produk Varian {{$product['size']}}"
											data-action="{{ route('backend.data.product.varian.destroy', ['pid' => $id, 'id' => $product['id']]) }}">
											Hapus
										</a> 								  
									</td>
								</tr>
							@endforeach
							@include('widgets.pageelements.formmodaldelete', [
									'modal_id'      => 'var_del', 
									'modal_route'   => route('backend.data.product.varian.destroy', 0)
							])					
						@endif
					</tbody>
				</table>
			</div>

			<div class="row">
				<div class="col-md-12">
					<h5><strong> Supplier &nbsp;</strong></h5>
					@if(!isset($suppliers[0]))
						<p class="m-l-sm m-t-sm text-left">Tidak ada supplier</p>
					@else
						<ul>
						@foreach($suppliers as $key => $value)
							<li>
								{!! $value['supplier_name'] !!} <a href="{{route('backend.data.supplier.show', $value['supplier_id'])}}"> detail </a>
							</li>
						@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>

	  
@stop

@section('script')
	$(document).ready(function() {
		$('.galery').hide().fadeIn('slow');
		$('.galery').attr("class","img img-responsive canvasSource");
	});

	function clickNext() {
		$('#car-btn-next').trigger("click");
	}

	function clickPrev() {
		$('#car-btn-prev').trigger("click");
	}
@stop

@section('script_plugin')
	@include('plugins.owlCarousel')
@stop