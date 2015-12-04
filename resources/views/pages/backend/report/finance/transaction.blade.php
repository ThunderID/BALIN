@inject('datas', 'App\Models\Transaction')
<?php 

if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}
$datas 			= $datas->status(['paid', 'packed', 'shipping', 'delivered'])->with(['user', 'supplier', 'transactiondetails', 'pointlogs'])->orderby('transact_at', 'desc')->paginate();

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
					{!! Form::open(array('route' => 'backend.report.finance.transaction', 'method' => 'get' )) !!}
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
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.report.finance.transaction') ])
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal</th>
									<th class="text-center">Debit</th>
									<th class="text-center">Kredit</th>
									<th class="text-center">Saldo</th>
									<th class="text-center">Catatan</th>
								</tr>
							</thead>
							<tbody>
								<?php $amount = 0;?>
								@forelse($datas as $key => $value)
									<?php 
										if($value->type=='sell')
										{
											$amount 	= $amount + $value->amount;
										}
										else
										{
											$amount 	= $amount - $value->amount;
										}
									;?>
									<tr>
										<td>{!!($key+1)!!}</td>
										<td class="text-center"> @date_indo($value->transact_at) </td>
										@if($value->type=='sell')
											<td class="text-right">@money_indo(abs($value->amount))</td>
										@else
											<td></td>
										@endif
										@if($value->type=='buy')
											<td class="text-right">@money_indo(abs($value->amount))</td>
										@else
											<td></td>
										@endif
										<td class="text-right">@money_indo(($amount))</td>
										@if($value->type=='sell')
											<td>Transaksi Jual {!!$value->user->name!!}</td>
										@else
											<td>Transaksi Beli {!!$value->supplier->name!!}</td>
										@endif
									</tr>
								@empty
									<tr>
										<td colspan="6" class="text-center"> Tidak ada data </td>
									</tr>
								@endforelse
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