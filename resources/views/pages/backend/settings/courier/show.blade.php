@inject('data', 'App\Models\Courier')

<?php $data = $data::id($id)->with(['shipments', 'shipments.transaction', 'shipments.transaction.user'])->first() ?>

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

	@if (count($data['shipments']) == 0)
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-capitalize">Data pengiriman dalam kategori ini</h3>
				 Tidak ada data
				 </br>
				 </br>
			 </div>
		 </div>
	@else
		<div class="table-responsive">
			<h3 class="text-capitalize">Data pengiriman dalam kategori ini</h3>
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
	@endif         
@stop