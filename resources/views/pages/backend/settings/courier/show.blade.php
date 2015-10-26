@inject('data', 'App\Models\Courier')

<?php $data = $data::id($id)->with(['shipments', 'shipments.transaction', 'shipments.transaction.user'])->with('shippingCosts')->first() ?>

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
		</div>
	</div>
	</br>

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
			{!! Form::open(array('route' => 'backend.data.product.index', 'method' => 'get' )) !!}
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
	@include('widgets.backend.pageElements.headerSearchResult', ['closeSearchLink' => route('backend.data.product.index') ])


	<div class="table-responsive">
		</br>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Awal kode Pos</th>
					<th>Akhir kode Pos</th>
					<th>Biaya</th>
					<th>Kontrol</th>
				</tr>
			</thead>
			<tbody>
				@if (count($data['shippingcosts']) == 0)
					<tr>
						<td colspan="5">
							<p class="text-center">Tidak ada data</p>
						</td>
					</tr>
				@else
					@foreach($data['shippingcosts'] as $ctr => $shippingcost)
						<tr>
							<td>{{ $ctr+1 }}</td>
							<td>{{ $shippingcost['start_postal_code'] }}</td>
							<td>{{ $shippingcost['end_postal_code']  }}</td>
							<td>{{ $shippingcost['cost'] }}</td>
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

	@include(
		'widgets.pageElements.formModalDelete', [
				'modal_id'      => 'sc_del', 
				'modal_route'   => 'backend.settings.shippingcost.destroy'
			]
		)      


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
		'widgets.pageElements.formModalDelete', [
				'modal_id'      => 'product_del', 
				'modal_route'   => 'backend.settings.shipment.destroy'
			]
		)      
	*/ ?>
@stop