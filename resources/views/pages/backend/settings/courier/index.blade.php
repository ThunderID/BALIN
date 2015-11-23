@inject('datas', 'App\Models\Courier')

<?php 
if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}

$datas 			= $datas->with(['addresses', 'images']);

if(Input::has('sort'))
{
	$datas 			= $datas->sort(Input::get('sort'));
}
else
{
	$datas 			= $datas->orderby('name', 'desc');
}

$datas 				= $datas->paginate();

?>


@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
					<a class="btn btn-default" href="{{ URL::route('backend.settings.courier.create') }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ URL::route('backend.settings.courier.create') }}"> Data Baru </a>
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(array('route' => 'backend.settings.courier.index', 'method' => 'get' )) !!}
					<div class="row">
						<div class="col-md-2 col-sm-3 hidden-xs">
						</div>
						<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
							{!! Form::input('text', 'q', Null , [
										'class'         => 'form-control',
										'placeholder'   => 'Cari nama kurir',
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
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.settings.courier.index') ])
			</br> 
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th class="text-center">Logo</th>
									<th class="col-md-2 text-center">
										Nama
										@if(!Input::has('sort') || Input::get('sort')!='name-asc')
										<a href="{{route('backend.settings.courier.index', array_merge(Input::all(), ['sort' => 'name-asc']))}}"> <i class="fa fa-arrow-up"></i> </a>
										@else
										<i class="fa fa-arrow-up"></i>
										@endif
										@if(!Input::has('sort') || Input::get('sort')!='name-desc')
										<a href="{{route('backend.settings.courier.index', array_merge(Input::all(), ['sort' => 'name-desc']))}}"> <i class="fa fa-arrow-down"></i> </a>
										@else
										<i class="fa fa-arrow-down"></i>
										@endif
									</th>
									<th class="col-md-6 text-center">Alamat</th>
									<th class="col-md-2 text-center">Kontrol</th>
								</tr>
							</thead>
							<tbody>
								@if(count($datas) == 0)
									<tr>
										<td colspan="5" class="text-center">
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
											<td class="text-center">{{ $ctr }}</td>
											<td class="text-center">{!! HTML::image($data->logo, 'logo', ['class' => 'img-responsive', 'style' => 'max-width:100px;']) !!}</td>
											<td>{{ $data['name'] }}</td>
											<td>
												{{ $data['address']['address'] }}
												</br>
												<i class="fa fa-phone"></i> {{ $data['address']['phone'] }}
											</td>
											<td class="text-center">
												<a href="{{ route('backend.settings.courier.show', $data['id']) }}"> Detail</a>, 
												<a href="{{ route('backend.settings.courier.edit', $data['id']) }}"> Edit</a>, 
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#courier_del"
													data-id="{{$data['id']}}"
													data-title="Hapus Data Produk {{$data['name']}}"
													data-action="{{ route('backend.settings.courier.destroy', $data['id']) }}">
													Hapus
												</a>                                                                                      
											</td>    
										</tr>       
										<?php $ctr += 1; ?>                     
									@endforeach 
									
									@include('widgets.pageelements.formmodaldelete', [
											'modal_id'      => 'courier_del', 
											'modal_route'   => 'backend.settings.courier.destroy'
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