@inject('datas', 'App\Models\TransactionDetail')
<?php 

if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}
$datas 			= $datas->with(['varian', 'varian.product', 'transaction'])->paginate();

?>

@extends('template.backend.layout')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(array('route' => 'backend.report.movement.stock', 'method' => 'get' )) !!}
						<div class="row">
							<div class="col-md-2 col-sm-3 hidden-xs">
							</div>
							<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
								{!! Form::input('text', 'q', Null ,[
											'class'         => 'form-control date-format',
											'placeholder'   => 'Tanggal',
											'required'      => 'required',
																]) !!}
								{!! Form::hidden('type', Input::get('type')) !!}
							</div>
							<div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
								<button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
							</div>
						</div>
					{!! Form::close() !!}
				</div>            
			</div>
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.report.movement.stock') ])
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<tbody>
								<?php
									$nop = ($datas->currentPage() - 1) * 15;
									$ctr = 1 + $nop;
									$vid = 0;
								?> 
								@if (count($datas) == 0)
									<tr>
										<td colspan="4" class="text-center">
											Tidak ada data
										</td>
									</tr>
								@else
									@foreach ($datas as $data)
									@if($data['varian_id']!=$vid)
									@if($vid!=0)
									<tr>
										<th colspan="3">&nbsp;</th>
									</tr>
									@endif
									<tr>
										<th class="text-left">Nama Barang</th>
										<th class="text-left" colspan="2">{{ $data['varian']['product']['name'] }} {{ $data['varian']['size'] }}</th>
									</tr>
									<tr>
										<th class="text-left">SKU</th>
										<th class="text-left" colspan="2">{{ $data['varian']['sku'] }}</th>
									</tr>
									<tr>
										<th class="text-left">Tanggal</th>
										<th class="text-left">Stok Masuk</th>
										<th class="text-left">Stok Keluar</th>
									</tr>

									@endif
									<tr>
										<td class="text-left">@datetime_indo($data['transaction']['transact_at'])</td>
										@if($data['transaction']['type'] == 'buy')
										<td class="text-right">{{$data['quantity']}}</td>
										@else
										<td class="text-right"></td>
										@endif
										@if($data['transaction']['type'] == 'buy')
										<td class="text-right"></td>
										@else
										<td class="text-right">{{$data['quantity']}}</td>
										@endif
									</tr>
									<?php $ctr += 1; $vid = $data['varian_id']; ?>
									@endforeach 
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

@section('script_plugin')
	@include('plugins.input-mask')
@stop