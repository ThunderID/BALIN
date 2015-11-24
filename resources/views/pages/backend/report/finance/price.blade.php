@inject('datas', 'App\Models\Product')
<?php 

if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}
$datas 			= $datas->currentprice(true)->groupby('products.id')->orderby('hpp', 'desc')->paginate();

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
					{!! Form::open(array('route' => 'backend.report.finance.price', 'method' => 'get' )) !!}
						<div class="row">
							<div class="col-md-2 col-sm-3 hidden-xs">
							</div>
							<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
								{!! Form::input('text', 'q', Null ,[
											'class'         => 'form-control date-format',
											'placeholder'   => 'Tanggal',
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
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.report.finance.price') ])
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th class="">Item</th>
									<th class=" text-right">HPP</th>
									<th class=" text-right">HJ</th>
									<th class=" text-right">Selisih (Margin)</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$nop = ($datas->currentPage() - 1) * 15;
									$ctr = 1 + $nop;
								?> 
								@if (count($datas) == 0)
									<tr>
										<td colspan="5" class="text-center">
											Tidak ada data
										</td>
									</tr>
								@else                                                                 
									@foreach ($datas as $data)
									<tr>
										<td class="text-center">{{ $ctr }}</td>
										<td class="text-left">{{ $data['name'] }}</td>
										<td class="text-right">@money_indo($data['hpp']) </td>
										<td class="text-right">@money_indo($data['price'] - $data['discount']) </td>
										<td class="text-right">@money_indo($data['price'] - $data['discount'] - $data['hpp'])</td>
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