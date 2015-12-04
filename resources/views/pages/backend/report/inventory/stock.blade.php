@inject('datas', 'App\Models\TransactionDetail')
<?php 

if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}
$datas 			= $datas->with(['varian', 'varian.product'])->paginate();

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
					{!! Form::open(array('route' => 'backend.report.critical.stock', 'method' => 'get' )) !!}
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
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.report.critical.stock') ])
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								@if($subnav_active=='critical')
								<tr>
									<th class="text-center">No.</th>
									<th class=" text-left">#</th>
									<th class="text-center">Item</th>
									<th class=" text-center">Stok</th>
								</tr>
								@else
								<tr>
									<th rowspan="2" class="text-center">No.</th>
									<th rowspan="2" class="text-left">#</th>
									<th rowspan="2" class="text-center">Item</th>
									<th colspan="4" class="text-center">Stok</th>
								</tr>
								<tr>
									<th class="text-center">Gudang</th>
									<th class="text-center">Dipesan</th>
									<th class="text-center">Dibayar</th>
									<th class="text-center">Display</th>
								</tr>
								@endif
							</thead>
							<tbody>
								<?php
									$nop = ($datas->currentPage() - 1) * 15;
									$ctr = 1 + $nop;
								?> 
								@if (count($datas) == 0)
									<tr>
										@if($subnav_active=='critical')
										<td colspan="4" class="text-center">
											Tidak ada data
										</td>
										@else
										<td colspan="7" class="text-center">
											Tidak ada data
										</td>
										@endif
									</tr>
								@else                                                                 
									@foreach ($datas as $data)
									<tr>
										<td class="text-center">{{ $ctr }}</td>
										<td class="text-left">{{ $data['varian']['sku'] }}</td>
										<td class="text-left">{{ $data['varian']['product']['name'] }} {{ $data['varian']['size'] }}</td>
										@if($subnav_active=='critical')
										<td class="text-right">{{ $data['current_stock'] }} </td>
										@else
										<td class="text-right">{{ $data['inventory_stock'] }} </td>
										<td class="text-right">{{ $data['on_hold_stock'] }} </td>
										<td class="text-right">{{ $data['reserved_stock'] }} </td>
										<td class="text-right">{{ $data['current_stock'] }} </td>
										@endif
									</tr>       
									<?php $ctr += 1; ?>                     
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