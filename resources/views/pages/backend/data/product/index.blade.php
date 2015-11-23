@inject('datas', 'App\Models\Product')
@inject('store', 'App\Models\StoreSetting')
<?php 
$stock               = $store->ondate('now')->type('critical_stock')->first();

if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}
$datas 			= $datas->with(['varians', 'lables'])->currentprice(true)->currentstock(true);

if(Input::has('asc'))
{
	switch (Input::get('asc')) 
	{
			case 'price':
				$datas 			= $datas->orderby('prices.price', 'asc');
				break;
			case 'stock':
				$datas 			= $datas->orderby('current_stock', 'asc');
				break;
			default:
				$datas 			= $datas->orderby('name', 'asc');
				break;
	}	
}
elseif(Input::has('desc'))
{
	switch (Input::get('desc')) 
	{
			case 'price':
				$datas 			= $datas->orderby('prices.price', 'desc');
				break;
			case 'stock':
				$datas 			= $datas->orderby('current_stock', 'desc');
				break;
			default:
				$datas 			= $datas->orderby('name', 'desc');
				break;
	}	
}
else
{
	$datas 			= $datas->orderby('name', 'desc');
}

$datas 				= $datas->paginate();
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
					<a class="btn btn-default" href="{{ URL::route('backend.data.product.create') }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ URL::route('backend.data.product.create') }}"> Data Baru </a>
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(array('route' => 'backend.data.product.index', 'method' => 'get' )) !!}
					<div class="row">
						<div class="col-md-2 col-sm-3 hidden-xs">
						</div>
						<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
							{!! Form::input('text', 'q', Null , [
										'class'         => 'form-control',
										'placeholder'   => 'Cari nama produk',
										'required'      => 'required',
															]) !!}                                          
						</div>
						<div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
							<button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>            
			</div>
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.data.product.index') ])
			</br> 
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<!-- <th class="col-md-2 text-center">UPC</th> -->
									<th class="col-md-3">
										Nama Produk
										@if(!Input::has('asc') || Input::get('asc')!='name')
										<a href="{{route('backend.data.product.index', array_merge(Input::all(), ['asc' => 'name']))}}"> <i class="fa fa-arrow-up"></i> </a>
										@else
										<i class="fa fa-arrow-up"></i>
										@endif
										@if(!Input::has('desc') || Input::get('desc')!='name')
										<a href="{{route('backend.data.product.index', array_merge(Input::all(), ['desc' => 'name']))}}"> <i class="fa fa-arrow-down"></i> </a>
										@else
										<i class="fa fa-arrow-down"></i>
										@endif
									</th>
									<th class="col-md-2 text-center">
										Harga 
										@if(!Input::has('asc') || Input::get('asc')!='price')
										<a href="{{route('backend.data.product.index', array_merge(Input::all(), ['asc' => 'price']))}}"> <i class="fa fa-arrow-up"></i> </a>
										@else
										<i class="fa fa-arrow-up"></i>
										@endif
										@if(!Input::has('desc') || Input::get('desc')!='price')
										<a href="{{route('backend.data.product.index', array_merge(Input::all(), ['desc' => 'price']))}}"> <i class="fa fa-arrow-down"></i> </a>
										@else
										<i class="fa fa-arrow-down"></i>
										@endif

									</th>
									<th class="col-md-2 text-center">Ukuran</th>
									<th class="col-md-2 text-center">
										Stok Display
										@if(!Input::has('asc') || Input::get('asc')!='stock')
										<a href="{{route('backend.data.product.index', array_merge(Input::all(), ['asc' => 'stock']))}}"> <i class="fa fa-arrow-up"></i> </a>
										@else
										<i class="fa fa-arrow-up"></i>
										@endif
										@if(!Input::has('desc') || Input::get('desc')!='stock')
										<a href="{{route('backend.data.product.index', array_merge(Input::all(), ['desc' => 'stock']))}}"> <i class="fa fa-arrow-down"></i> </a>
										@else
										<i class="fa fa-arrow-down"></i>
										@endif

									</th>
									<th class="text-center">Kontrol</th>
								</tr>
							</thead>
							<tbody>
								@if(count($datas) == 0)
									<tr>
										<td colspan="6" class="text-center">
											Tidak ada data
										</td>
									</tr>
								@else                                                                 
									<?php
										$nop = ($datas->currentPage() - 1) * 15;
										$ctr = 1 + $nop;
									?> 
									@foreach($datas as $data)
										<tr>
											<td class="text-center">{{ $ctr }}</td>
											<!-- <td class="text-center">{{ $data['upc'] }}</td> -->
											<td>
												{{ $data['name'] }}
												<br/>
												@foreach($data['lables'] as $lable)
									                <label class="label label-success">{{ str_replace('_', ' ', ucfirst($lable['lable'] ) )}}</label> &nbsp;
												@endforeach
											</td>
											<td class="text-right">
												@if($data['discount']!=0)
													<strike>@money_indo($data['price'])</strike>
													@money_indo($data['promo_price'])
												@else
													@money_indo($data['price'])
												@endif
												 <br/>
												<a href="{{ route('backend.data.product.price.create', ['pid' => $data['id']]) }}">Ubah Harga</a>
											</td>
											<td class="text-center">
												@foreach($data['varians'] as $varian)
													{{ $varian['size'] }} &nbsp;
												@endforeach
												 <br/>
												<a href="{{ URL::route('backend.data.product.varian.create', ['uid' => $data['id'] ]) }}"> Ukuran Lain </a>
											</td>
											<td class="text-right">
												{{$data['current_stock']}}
												 <br/>
												@if($data['current_stock'] < $stock->value && $data->varians()->count())
												<a href="{{ route('backend.data.transaction.create', ['type' => 'buy']) }}">Stok Barang</a>
												@endif
											</td>
											<td class="text-center">
												<a href="{{ route('backend.data.product.show', $data['id']) }}"> Detail</a>,
												<a href="{{ url::route('backend.data.product.edit', $data['id']) }}"> Edit</a>, 
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#product_del"
													data-id="{{$data['id']}}"
													data-title="Hapus Data Produk {{$data['name']}}"
													data-action="{{ route('backend.data.product.destroy', $data['id']) }}">
													Hapus
												</a>                                                                                      
											</td>    
										</tr>       
										<?php $ctr += 1; ?>                     
									@endforeach 
									
									@include('widgets.pageelements.formmodaldelete', [
											'modal_id'      => 'product_del', 
											'modal_route'   => route('backend.data.product.destroy')
									])
								@endif
							</tbody>
						</table> 
					</div>                 
				</div>
			</div>

			@if(count($datas) > 0)
				<div class="row">
					<div class="col-md-12" style="text-align:right;">
						{!! $datas->appends(Input::all())->render() !!}
					</div>
				</div>
			@endif
		</div>
	</div>
@stop