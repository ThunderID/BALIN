@inject('data', 'App\Models\Shipment')
@inject('shippingcosts', 'App\Models\ShippingCost')

<?php 
$data 					= $data::courierid($id)->transactionstatus('shipping')->with(['address'])->get();

if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$shippingcosts = call_user_func([$shippingcosts, $key], $value);
	}
}

$shippingcosts = $shippingcosts->courierid($courier['id'])->get();
?>

@extends('template.backend.layout')

@section('content')
	<div class="row">
		<div class="col-md-6">
			<h4 class="sub-header">
				Informasi Kurir
			</h4>
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Nama<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p class="text-capitalize">{{ $courier['name'] }}</p>
				</div>
			</div> 
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Telepon<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p>{!!$courier['address']['phone']!!}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Alamat<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p>{!!$courier['address']['address']!!}</p>
					<p>{!!$courier['address']['zipcode']!!}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Jumlah Pengiriman<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p>{{ count($data) }}</p>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<h4 class="sub-header">
				Data pengiriman kurir ini (ongoing)
			</h4>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<!-- <th>No</th> -->
									<th class="">#</th>
									<th class="">Tanggal</th>
									<th class="">Penerima</th>
									<th>Alamat</th>
								</tr>
							</thead>
							<tbody>
								@if (count($data) == 0)
								<tr>
									<td colspan="4">
										<p class="text-center">Tidak ada data</p>
									</td>
								</tr>					
								@else
									@foreach($data as $ctr => $shipment)
										<tr>
											<!-- <td>{{ $ctr+1 }}</td> -->
											<td>
												<a href="{{route('backend.data.shipment.index', ['receiptnumber' => $shipment['receipt_number']])}}">{{ $shipment['receipt_number'] }}
											</td>
											<td>{{ date('Y-m-d H:i:s', strtotime($shipment['updated_at'])) }}</td>
											<td>{{ $shipment['receiver_name'] }}</td>
											<td>{{ $shipment['address']['address'] }}</td>
												<?php /*
												<a href="{{ route('backend.settings.shipment.show', $shipment->id) }}"> Detail </a>,
												<a href="{{ route('backend.settings.shipment.edit', $shipment->id) }}"> Edit </a>,
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#product_del"
													data-id="{{$shipment['id']}}"
													data-title="Hapus Data Pengiriman {{$shipment['name']}}">
													Hapus
												</a>   
												*/ ?>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div> 
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-md-12">
			<h4 class="sub-header">
				Ongkos Kirim  <small><a href="{{ URL::route('backend.settings.shippingCost.create', ['id' => $courier['id'] ]) }}"> Tambah </a></small>
			</h4>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>Kode Pos</th>
									<th>Biaya</th>
									<th>Tanggal berlaku</th>
									<th>Kontrol</th>
								</tr>
							</thead>
							<tbody>
								@if (count($shippingcosts) == 0)
									<tr>
										<td colspan="6">
											<p class="text-center">Tidak ada data</p>
										</td>
									</tr>
								@else
									@foreach($shippingcosts as $ctr => $shippingcost)
										<tr>
											<td>{{ $shippingcost['start_postal_code'] }} - {{ $shippingcost['end_postal_code']  }}</td>
											<td>@money_indo($shippingcost['cost'])</td>
											<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $shippingcost['started_at'])->format('d-m-Y h:i')}}</td>
											<td> 
												<a href="{{ route('backend.settings.shippingCost.edit', ['cou_id' => $courier['id'], 'id' => $shippingcost['id']]) }}"> Edit </a>,
												
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#sc_del"
													data-id="{{$shippingcost['id']}}"
													data-title="Hapus Data Ongkos Kirim {{$shippingcost['start_postal_code']}} - {{$shippingcost['start_postal_code']}}">
													Hapus
												</a>   
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>

					@include('widgets.pageelements.formmodaldelete', [
								'modal_id'      => 'sc_del', 
								'modal_route'   => route('backend.settings.shippingCost.destroy')
					])      
				</div>
			</div>
		</div>
	</div>
	

	<?php /*
	@if(count($shippingcosts) > 0)
						<div class="row">
							<div class="col-md-12" style="text-align:right;">
				                {!! $shippingcosts->appends(Input::all())->render() !!}
							</div>
						</div>
					@endif
	<!-- 		<div class="col-md-8 col-sm-4 hidden-xs">
			<a class="btn btn-default" href="{{ URL::route('backend.settings.shippingCost.create', ['id' => $data['id'] ]) }}"> Data Baru </a>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<a class="btn btn-default btn-block" href="{{ URL::route('backend.settings.shippingCost.create', ['id' => $data['id'] ]) }}"> Data Baru </a>
		</div>
		<div class="col-md-4 col-sm-8 col-xs-12">
			{!! Form::open(array('method' => 'get' )) !!}
			<div class="row">
				<div class="col-md-2 col-sm-3 hidden-xs">
				</div>
				<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
					{!! Form::input('text', 'q', Null , [
								'class'         => 'form-control',
								'placeholder'   => 'Cari sesuatu',
								'required'      => 'required',
					$this->address
						]) !!}                                          
				</div>
				<div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
					<button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>            
	</div>
	@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.settings.courier.show', ['id' => $data['id']]) ])
 -->
	@include(
		'widgets.pageelements.formmodaldelete', [
				'modal_id'      => 'product_del', 
				'modal_route'   => 'backend.settings.shipment.destroy'
			]
		)      
	*/ ?>
@stop