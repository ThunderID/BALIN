@inject('datas', 'App\Models\Transaction')
<?php 
if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}
$datas 			= $datas->type($subnav_active)->orderby('transact_at')->with(['user', 'supplier'])->paginate();

if ($subnav_active == 'sell')
{
	$type_user  = 'Kostumer';
}
else
{
	$type_user  = 'Supplier';
}
?>

@extends('template.backend.layout')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
					<a class="btn btn-default" href="{{ URL::route('backend.data.transaction.create', ['type' => $subnav_active]) }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ URL::route('backend.data.transaction.create', ['type' => $subnav_active]) }}"> Data Baru </a>
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(array('route' => 'backend.data.transaction.index', 'method' => 'get' )) !!}
						<div class="row">
							<div class="col-md-2 col-sm-3 hidden-xs">
							</div>
							<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
								{!! Form::input('text', 'q', Null ,[
											'class'         => 'form-control',
											'placeholder'   => 'Cari sesuatu',
											'required'      => 'required',
											'style'         =>'text-align:right'
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
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.data.supplier.index') ])
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th class=" text-left">#</th>
									<th class="">{{ $type_user }}</th>
									<th class=" text-center">Tanggal Transaksi</th>
									<th class=" text-center">Status</th>
									<th class=" text-center">Total</th>
									<th class="">Kontrol</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$nop = ($datas->currentPage() - 1) * 15;
									$ctr = 1 + $nop;
								?> 
								@if (count($datas) == 0)
									<tr>
										<td colspan="6" class="text-center">
											Tidak ada data
										</td>
									</tr>
								@else                                                                 
									@foreach ($datas as $data)
									<tr>
										<td class="text-center">{{ $ctr }}</td>
										<td class="text-left">{{ $data['ref_number'] }}</td>
										@if($type_user=='Kostumer')
											<td>{{ $data['user']['name'] }}</td>
										@else
											<td>{{ $data[$type_user]['name'] }}</td>
										@endif
										<td class="text-center">{{ $data['transact_at'] }}</td>
										<td class="text-center">{{ $data['status'] }} </td>
										<td class="text-center">{{ $data['amount'] }} </td>
										<td>
											<a href="{{route('backend.data.transaction.show', ['id' => $data['id'], 'type' => $data['type']])}}">Detail</a>,
											<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#trans" 
												data-id="{{ $data['id'] }}" 
												data-nota-transaksi="{{ $data['invoice_no'] }}" 
												data-name="{{ $data['customer']['name'] }}" 
												data-date="{{ $data['date'] }}" 
												data-status="{{ $data['status'] }}"  
												data-title="Edit Data {{ $data['transaction']['invoice_no'] }}" 
												data-button="Simpan Data"
												href="#">
												Edit
											</a>,  
											<a data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#trans_del"
												data-id="{{$data['id']}}"
												data-title="Hapus Data Transaksi {{$data['invoice_no']}}" 
												data-button="Hapus Data"
												data-action="{{ route('backend.data.transaction.destroy', [$data['id'], 'type' => $subnav_active]) }}">
												Hapus
											</a>                                            
										</td>    
									</tr>       
									<?php $ctr += 1; ?>                     
									@endforeach 
									@include('widgets.pageelements.formmodaldelete', [
											'modal_id'      => 'trans_del', 
											'modal_route'   => route('backend.data.transaction.destroy', 0)
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

@section('script')
	$('#trans_del').on('show.bs.modal', function (e) {
		var id = $(e.relatedTarget).attr('data-id');
		var title = $(e.relatedTarget).attr('data-title');
		var button = $(e.relatedTarget).attr('data-button');

		$('.mod_pwd').val('');
		$('.mod_id').val(id);
		$('.mod_title').html(title);
		$('.mod_button').html(button);
	}) 

	$('#trans').on('show.bs.modal', function (e) {
		var title = $(e.relatedTarget).attr('data-title');
		var button = $(e.relatedTarget).attr('data-button');
		var id = $(e.relatedTarget).attr('data-id');
		var nota_transaksi = $(e.relatedTarget).attr('data-nota-transaksi');
		var name = $(e.relatedTarget).attr('data-name');
		var phone = $(e.relatedTarget).attr('data-phone');
		var address = $(e.relatedTarget).attr('data-address');
		var zip = $(e.relatedTarget).attr('data-zip');
		var courier = $(e.relatedTarget).attr('data-courier');
		var code = $(e.relatedTarget).attr('data-code');
		var cost = $(e.relatedTarget).attr('data-cost');
		var date = $(e.relatedTarget).attr('data-date');

		$('.mod_id').val(id);
		$('.mod_nota_transaksi').val(nota_transaksi);
		$('.mod_date').val(date);
		$('.mod_name').val(name);
		$('.mod_phone').val(phone);
		$('.mod_address').val(address);
		$('.mod_zip').val(zip);
		$('.mod_courier').val(courier);
		$('.mod_resi').val(code);
		$('.mod_cost').val(cost);
		$('.mod_title').html(title);
		$('.mod_button').html(button);
	})     
@stop