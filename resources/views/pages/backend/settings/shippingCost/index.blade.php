@inject('datas', 'App\Models\shippingCost')
<?php 
$datas 			= $datas
					->with('courier')
					->paginate();
?>


@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
					<a class="btn btn-default" href="{{ URL::route('backend.settings.shippingCost.create') }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ URL::route('backend.data.shippingCost.create') }}"> Data Baru </a>
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(array('route' => 'backend.settings.shippingCost.index', 'method' => 'get' )) !!}
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
							</div>
							<div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
								<button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
							</div>
						</div>
					{!! Form::close() !!}
				</div>            
			</div>
			@include('widgets.backend.pageElements.headerSearchResult', ['closeSearchLink' => route('backend.settings.shippingCost.index') ])
			</br> 
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama Kurir</th>
									<th class="text-center">Awal Kode Pos</th>
									<th class="text-center">Akhir Kode Pos</th>
									<th class="text-center">Biaya</th>
									<th>Kontrol</th>
								</tr>
							</thead>
							<tbody>
								@if(count($datas) == 0)
									<tr>
										<td colspan="4" class="text-center">
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
										<td>{{$ctr}}</td>
										<td>{{$data['courier']['name']}}</td>
										<td class="text-center">{{$data['start_postal_code']}}</td>                                                                               
										<td class="text-center">{{$data['end_postal_code']}}</td>                                                                               
										<td class="text-center">{{$data['cost']}}</td>                                                                               
										<td>
											<a href="{{ URL::route('backend.settings.shippingCost.show', ['id' => $data['id']]) }}"> Detail </a>, 
											<a href="{{ URL::route('backend.settings.shippingCost.edit', ['id' => $data['id']]) }}"> Edit </a>, 
											<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#shippingCost_del"
												data-id="{{ $data['id'] }}"
												data-title="Hapus Data Ongkos Kirim {{$data['courier']['name']}}"
												data-action="{{ route('backend.settings.shippingCost.destroy', $data->id) }}">
												Hapus
											</a>  
										</td>    
									</tr>       
									<?php $ctr += 1; ?>                     
									@endforeach 
									@include('widgets.pageElements.formModalDelete', [
											'modal_id'      => 'shippingCost_del', 
											'modal_route'   => route('backend.settings.shippingCost.destroy', 0)
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