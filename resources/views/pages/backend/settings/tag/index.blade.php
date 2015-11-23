@inject('datas', 'App\Models\Tag')
<?php 
if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}
$datas 			= $datas->orderby('path')->paginate();
?>
@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
					<a class="btn btn-default" href="{{ route('backend.settings.tag.create') }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ URL::route('backend.settings.tag.create') }}"> Data Baru </a>
				</div>
                <div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(array('route' => 'backend.settings.tag.index', 'method' => 'get' )) !!}
					<div class="row">
						<div class="col-md-2 col-sm-3 hidden-xs">
						</div>
						<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
							{!! Form::input('text', 'q', Null ,
									[
										'class'         => 'form-control',
										'placeholder'   => 'Cari tag',
										'required'      => 'required',
									]
								) !!}                                  
						</div>
						<div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
							<button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>            
			</div>
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.settings.tag.index') ])
			</br> 
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th colspan="2">Nama Tag</th>
									<th class="text-center">Kontrol</th>
								</tr>
							</thead>                            
							<tbody>
								@if (count($datas) == 0)
									<tr>
										<td colspan="6" class="text-center">
											Tidak ada data
										</td>
									</tr>
								@else                                                                                           
									@foreach ($datas as $data)
										<tr>
											<td>
												@if ($data['category_id'] == 0)
													<i class="fa fa-circle" style="font-size:5px; margin-left:5px;"></i>
												@endif
											</td>
											<td class="col-md-10">
												<p class="text-capitalize">
													@for ($i = 0; $i < substr_count($data['path'],','); $i++)
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													@endfor
													{{$data['name']}}
												</p>
											</td>
											<td class="text-center">
												<a href="{{ route('backend.settings.tag.show',  $data['id']) }}"> Detail</a>,
												<a href="{{ route('backend.settings.tag.edit', ['id' => $data['id']]) }}"> Edit</a>, 
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#tag_del"
													data-id="{{$data['id']}}"
													data-title="Hapus Data Tag {{$data['name']}}"
													data-action="{{ route('backend.settings.tag.destroy', $data['id']) }}">
													Hapus
												</a>                                                                                 
											</td>    
										</tr>
									@endforeach 
									@include('widgets.pageelements.formmodaldelete', [
										'modal_id'      => 'tag_del', 
										'modal_route'   => 'backend.settings.tag.destroy'
									])                                    
								@endif
							</tbody>
						</table> 
					</div>                 
				</div>
			</div>
			@if (count($datas) > 0)
				<div class="row">
					<div class="col-md-12" style="text-align:right;">
						{!! $datas->appends(Input::all())->render() !!}
					</div>
				</div>
			@endif            
		</div>
	</div>    
@stop