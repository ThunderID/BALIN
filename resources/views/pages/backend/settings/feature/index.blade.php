@inject('datas', 'App\Models\StoreSetting')

<?php 
if(!is_null($filters) && is_array($filters))
{
	foreach ($filters as $key => $value) 
	{
		$datas = call_user_func([$datas, $key], $value);
	}
}
$datas 			= $datas->orderby('started_at', 'desc')->Type('slider')->paginate();

?>


@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
					<a class="btn btn-default" href="{{ URL::route('backend.settings.feature.create') }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ URL::route('backend.settings.feature.create') }}"> Data Baru </a>
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(array('route' => 'backend.settings.feature.index', 'method' => 'get' )) !!}
					<div class="row">
						<div class="col-md-2 col-sm-3 hidden-xs">
						</div>
						<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
							{!! Form::input('text', 'q', Null , [
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
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.settings.feature.index') ])
			</br> 
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th class="text-center col-md-4">Slide</th>
									<th class="text-center col-md-5">Konten</th>
									<th class="text-center col-md-2">Ditampilkan</th>
									<th class="text-center col-md-2">Kontrol</th>
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
										<?php
											$value = (array)json_decode($data['value'], true);
										?>
										<tr>
											<td class="text-center">{{ $ctr }}</td>
											<td class="text-center col-md-4">{!! HTML::image($data->slider, 'slider', ['class' => 'img-responsive', 'style' => 'max-width:300px;']) !!}</td>
											<td>
												@if(isset($value['title']['slider_title']))
													@if($value['title']['title_active'] == 1)
														<h5><strong>Judul :</strong>
															{!! $value['title']['slider_title'] !!}
														</h5>
													@else
														<h5><strong>Judul tidak aktif</strong></h5>
													@endif
												@else
													<h5><strong>Judul tidak aktif</strong></h5>
												@endif

												@if(isset($value['content']['slider_content']))
													@if($value['content']['content_active'] == 1)
														<h5><strong>Konten :</strong>
															{!! $value['content']['slider_content'] !!}
														</h5>
													@else
														<h5><strong>Konten tidak aktif</strong></h5>
													@endif
												@else
													<h5><strong>Konten tidak aktif</strong></h5>
												@endif		

												@if(isset($value['button']['slider_button']))
													@if($value['button']['button_active'] == 1)
														<h5><strong>Tombol :</strong>
															{!! $value['button']['slider_button'] !!}
														</h5>
													@else
														<h5><strong>Tombol tidak aktif</strong></h5>
													@endif
												@else
													<h5><strong>Tombol tidak aktif</strong></h5>
												@endif																						
											</td>
											<td>
												@datetime_indo($data['started_at']) - 
												@datetime_indo($data['ended_at'])
											</td>
											<td class="text-center">
												<a href="{{ route('backend.settings.feature.show.preview', $data['id']) }}"> Preview</a>, 
												<a href="{{ route('backend.settings.feature.edit', $data['id']) }}"> Edit</a>, 
												<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#feature_del"
													data-id="{{$data['id']}}"
													data-title="Hapus Data Produk {{$data['name']}}"
													data-action="{{ route('backend.settings.feature.destroy', $data['id']) }}">
													Hapus
												</a>                                                                                      
											</td>    
										</tr>       
										<?php $ctr += 1; ?>                     
									@endforeach 
									
									@include('widgets.pageelements.formmodaldelete', [
											'modal_id'      => 'feature_del', 
											'modal_route'   => 'backend.settings.feature.destroy'
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

@section('script_plugin')
	@include('plugins.input-mask')
@stop