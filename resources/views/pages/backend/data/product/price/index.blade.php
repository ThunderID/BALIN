@inject('datas', 'App\Models\Price')
<?php 
if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}
$datas 			= $datas->where('product_id', $pid)->orderby('started_at', 'desc')->paginate();
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
					<a class="btn btn-default" href="{{ route('backend.data.product.price.create', ['pid' => $pid, 'uid' => $uid]) }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ route('backend.data.product.price.create', ['pid' => $pid, 'uid' => $uid]) }}"> Data Baru </a>
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(['url' => route('backend.data.product.price.index', ['product_id' => $pid]), 'method' => 'get' ]) !!}
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
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.data.product.price.index') ])
			</br> 
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>No.</th>
									<th class="col-md-3 text-center">Tanggal Mulai</th>
									<th class="col-md-3 text-right">Harga</th>
									<th class="col-md-3 text-right">Harga Promo</th>
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
											<td>{{ $ctr }}</td>
											<td class="text-center">{{ $data['started_at'] }}</td>
											<td class="text-right">@money_indo($data['price'])</td>
											<td class="text-right">@money_indo($data['promo_price'])</td>
											<td class="text-center">
												{{-- <a href="{{ route('backend.data.product.show', $data['id']) }}"> Detail </a>, --}}
												<a href="{{ route('backend.data.product.price.edit', [$data['id'], 'pid' => $pid, 'uid' => $uid]) }}"> Edit </a>,
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#product_del"
													data-id="{{$data['id']}}"
													data-title="Hapus Data Harga Produk"
													data-action="{{ route('backend.data.product.price.destroy', ['id' => $data['id'], 'pid' => $pid, 'uid' => $uid]) }}">
													
													Hapus
												</a>
											</td>    
										</tr>       
										<?php $ctr += 1; ?>                     
									@endforeach 
									
									@include('widgets.pageelements.formmodaldelete', [
											'modal_id'      => 'product_del', 
											'modal_route'   => route('backend.data.product.price.destroy', 0)
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