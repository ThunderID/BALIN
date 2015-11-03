@inject('data', 'App\Models\Courier')
@inject('shippingcosts', 'App\Models\ShippingCost')

<?php 
$data = $data::id($id)->with(['shipments', 'shipments.transaction', 'shipments.transaction.user'])->first();

if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$shippingcosts = call_user_func([$shippingcosts, $key], $value);
	}
}
$shippingcosts = $shippingcosts->courierid($data['id'])->paginate();
?>

@extends('template.backend.layout')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="row">
					<h3 class="text-capitalize">Informasi Kurir</h3>
					<div class="row">
						<div class="col-md-4 text-left">
							<p class="text-capitalize">Nama Kurir<span class="pull-right">:</span></p>
						</div>
						<div class="col-md-8">
							<p class="text-capitalize">{{ $data['name'] }}</p>
						</div>
					</div> 
					<div class="row">
						<div class="col-md-4 text-left">
							<p class="text-capitalize">Jumlah Pengiriman<span class="pull-right">:</span></p>
						</div>
						<div class="col-md-8">
							<p>{{ count($data['shipments']) }}</p>
						</div>
					</div>                                                        
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<h3 class="text-capitalize">Alamat Kurir</h3>
					<div class="row">
						<div class="col-md-4 text-left">
							<p class="text-capitalize">Nomor Telepon<span class="pull-right">:</span></p>
						</div>
						<div class="col-md-8">
							<p class="text-capitalize">{{ $data['address']['phone'] }}</p>
						</div>
					</div> 
					<div class="row">
						<div class="col-md-4 text-left">
							<p class="text-capitalize">Kode Pos<span class="pull-right">:</span></p>
						</div>
						<div class="col-md-8">
							<p>{{ $data['address']['zipcode'] }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 text-left">
							<p class="text-capitalize">Alamat<span class="pull-right">:</span></p>
						</div>
						<div class="col-md-8">
							<p>{{ $data['address']['address'] }}</p>
						</div>
					</div> 					                                                    
				</div>
			</div>			
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-capitalize">Data Ongkos Kirim</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-sm-4 hidden-xs">
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
	@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.settings.courier.show', ['id' => $data['id']]) ])

	<div class="table-responsive">
		</br>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Awal kode Pos</th>
					<th>Akhir kode Pos</th>
					<th>Biaya</th>
					<th>Tanggal berlaku</th>
					<th>Kontrol</th>
				</tr>
			</thead>
			<tbody>
				@if (count($shippingcosts) == 0)
					<tr>
						<td colspan="5">
							<p class="text-center">Tidak ada data</p>
						</td>
					</tr>
				@else
					@foreach($shippingcosts as $ctr => $shippingcost)
						<tr>
							<td>{{ $ctr+1 }}</td>
							<td>{{ $shippingcost['start_postal_code'] }}</td>
							<td>{{ $shippingcost['end_postal_code']  }}</td>
							<td>{{ $shippingcost['cost'] }}</td>
							<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $shippingcost['started_at'])->format('d-m-Y h:i A')}}</td>
							<td> 
								<a href="{{ route('backend.settings.shippingCost.edit', ['cou_id' => $data['id'], 'id' => $shippingcost['id']]) }}"> Edit </a>,
								
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

	@if(count($shippingcosts) > 0)
		<div class="row">
			<div class="col-md-12" style="text-align:right;">
                {!! $shippingcosts->appends(Input::all())->render() !!}
			</div>
		</div>
	@endif

	@include('widgets.pageelements.formmodaldelete', [
				'modal_id'      => 'sc_del', 
				'modal_route'   => route('backend.settings.shippingCost.destroy')
	])      

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-capitalize">Data pengiriman dalam kategori ini</h3>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th class="col-md-3">#</th>
					<th class="col-md-7">Tanggal</th>
					<th class="col-md-7">Kostumer</th>
					<th>Kontrol</th>
				</tr>
			</thead>
			<tbody>
				@if (count($data['shipments']) == 0)
				<tr>
					<td colspan="5">
						<p class="text-center">Tidak ada data</p>
					</td>
				</tr>					
				@else
					@foreach($data['shipments'] as $ctr => $shipment)
						<tr>
							<td>{{ $ctr+1 }}</td>
							<td>{{ $shipment['transaction']['ref_number'] }}</td>
							<td>{{ date('Y-m-d H:i:s', strtotime($shipment['transaction']['transacted_at'])) }}</td>
							<td>{{ $shipment['transaction']['user']['name'] }}</td>
							<td> 
								<?php /*
								<a href="{{ route('backend.settings.shipment.show', $shipment->id) }}"> Detail </a>,
								<a href="{{ route('backend.settings.shipment.edit', $shipment->id) }}"> Edit </a>,
								<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#product_del"
									data-id="{{$shipment['id']}}"
									data-title="Hapus Data Pengiriman {{$shipment['name']}}">
									Hapus
								</a>   
								*/ ?>
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>  

	<?php /*
	@include(
		'widgets.pageelements.formmodaldelete', [
				'modal_id'      => 'product_del', 
				'modal_route'   => 'backend.settings.shipment.destroy'
			]
		)      
	*/ ?>
@stop