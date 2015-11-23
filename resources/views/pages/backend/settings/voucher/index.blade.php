@inject('datas', 'App\Models\Voucher')

<?php 
if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}

$datas 			= $datas->currentquota(true);

if(Input::has('asc'))
{
	switch (Input::get('asc')) 
	{
			case 'quota':
				$datas 			= $datas->orderby('current_quota', 'asc');
				break;
			case 'startedat':
				$datas 			= $datas->orderby('started_at', 'asc');
				break;
			default:
				$datas 			= $datas->orderby('type', 'asc');
				break;
		}	
}
elseif(Input::has('desc'))
{
	switch (Input::get('desc')) 
	{
			case 'quota':
				$datas 			= $datas->orderby('current_quota', 'desc');
				break;
			case 'startedat':
				$datas 			= $datas->orderby('started_at', 'desc');
				break;
			default:
				$datas 			= $datas->orderby('type', 'desc');
				break;
		}	
}
else
{
	$datas 			= $datas->orderby('type', 'asc');
}

$datas 				= $datas->paginate();
?>


@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
					<a class="btn btn-default" href="{{ URL::route('backend.settings.voucher.create') }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ URL::route('backend.settings.voucher.create') }}"> Data Baru </a>
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(array('route' => 'backend.settings.voucher.index', 'method' => 'get' )) !!}
					<div class="row">
						<div class="col-md-2 col-sm-3 hidden-xs">
						</div>
						<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
							{!! Form::input('text', 'q', Null , [
										'class'         => 'form-control',
										'placeholder'   => 'Cari code voucher',
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
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.settings.voucher.index') ])
			</br> 
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th class="text-center">Code</th>
									<th class="text-center">
										Tipe
										@if(!Input::has('asc') || Input::get('asc')!='type')
										<a href="{{route('backend.settings.voucher.index', array_merge(Input::all(), ['asc' => 'type']))}}"> <i class="fa fa-arrow-up"></i> </a>
										@else
										<i class="fa fa-arrow-up"></i>
										@endif
										@if(!Input::has('desc') || Input::get('desc')!='type')
										<a href="{{route('backend.settings.voucher.index', array_merge(Input::all(), ['desc' => 'type']))}}"> <i class="fa fa-arrow-down"></i> </a>
										@else
										<i class="fa fa-arrow-down"></i>
										@endif
									</th>
									<th class="text-center">
										Quota
										@if(!Input::has('asc') || Input::get('asc')!='quota')
										<a href="{{route('backend.settings.voucher.index', array_merge(Input::all(), ['asc' => 'quota']))}}"> <i class="fa fa-arrow-up"></i> </a>
										@else
										<i class="fa fa-arrow-up"></i>
										@endif
										@if(!Input::has('desc') || Input::get('desc')!='quota')
										<a href="{{route('backend.settings.voucher.index', array_merge(Input::all(), ['desc' => 'quota']))}}"> <i class="fa fa-arrow-down"></i> </a>
										@else
										<i class="fa fa-arrow-down"></i>
										@endif
									</th>
									<th class="col-md-4 text-center">
										Masa Berlaku
										@if(!Input::has('asc') || Input::get('asc')!='startedat')
										<a href="{{route('backend.settings.voucher.index', array_merge(Input::all(), ['asc' => 'startedat']))}}"> <i class="fa fa-arrow-up"></i> </a>
										@else
										<i class="fa fa-arrow-up"></i>
										@endif
										@if(!Input::has('desc') || Input::get('desc')!='startedat')
										<a href="{{route('backend.settings.voucher.index', array_merge(Input::all(), ['desc' => 'startedat']))}}"> <i class="fa fa-arrow-down"></i> </a>
										@else
										<i class="fa fa-arrow-down"></i>
										@endif
									</th>
									<th class="col-md-3 text-center">Kontrol</th>
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
											<td>{{ $data['code'] }}</td>
											<td>{{ str_replace('_', ' ', $data['type']) }} : {{$data['value']}}</td>
											<td class="text-right">{{ $data['quota'] }}</td>
											<td class="text-center">
												@if(!is_null($data['started_at']) && !is_null($data['expired_at']))
												@datetime_indo($data['started_at'])
												- @datetime_indo($data['expired_at'])
												@else
													<i>No Limit</i>
												@endif
											</td>
											<td class="text-center">
												<a href="{{ route('backend.settings.voucher.getmail', $data['id']) }}"> Broadcast</a>, 
												<a href="{{ route('backend.settings.quota.index', ['vou_id' => $data['id']]) }}"> Quota</a>, 
												<a href="{{ route('backend.settings.voucher.show', $data['id']) }}"> Detail</a>, 
												<a href="{{ route('backend.settings.voucher.edit', $data['id']) }}"> Edit</a>, 
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#courier_del"
													data-id="{{$data['id']}}"
													data-title="Hapus Data Voucher {{$data['code']}}"
													data-action="{{ route('backend.settings.voucher.destroy', $data['id']) }}">
													Hapus
												</a>                                                                                      
											</td>    
										</tr>       
										<?php $ctr += 1; ?>                     
									@endforeach 
									
									@include('widgets.pageelements.formmodaldelete', [
											'modal_id'      => 'courier_del', 
											'modal_route'   => 'backend.settings.voucher.destroy'
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