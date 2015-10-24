@inject('datas', 'App\Models\pointlog')
<?php
$datas 			= $datas
					->RangeDate($start, $end)
					->orderby('id', 'desc')
					->with('user')
					->paginate()
					;
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-6 hidden-sm hidden-xs"></div>
			{!! Form::open(array('route' => 'backend.report.pointlog', 'method' => 'get' )) !!}
			<div class="col-md-6 col-sm-12 col-xs12">
				<div class"row">
					<div class="col-md-5 col-sm-5 col-xs-12">
						{!! 
	                        Form::input(
	                            'date',
	                            'start_date', 
	                            null, 
	                            [
	                                'class'         => 'form-control', 
	                                'required'      => 'required', 
	                                'tabindex'      => '1',
	                                'placeholder'   => 'Tanggal berlaku harga'
	                            ] 
	                        ) 
	                    !!}
	                </div>
					<div class="col-md-1 col-sm-1 hidden-xs">
		                <p style="padding-top:6px;">to</p>
					</div>
					<div class="hidden-lg hidden-md hidden-sm col-xs-12">
		                <p class="text-center" style="padding-top:5px;">to</p>
					</div>
					<div class="col-md-5 col-sm-5 col-xs-12">
						{!! 
	                        Form::input(
	                            'date',
	                            'end_date', 
	                            null, 
	                            [
	                                'class'         => 'form-control', 
	                                'required'      => 'required', 
	                                'tabindex'      => '1',
	                                'placeholder'   => 'Tanggal berlaku harga'
	                            ] 
	                        ) 
	                    !!}
	                </div>	
					<div class="col-md-1">
	                    <button type="submit" class="btn btn-md btn-default" tabindex="5">Go</button>
	                </div>			                		                
				</div>
			</div>
			{!! Form::close() !!}
		</div> 				
	</div>
	</br>
	@include('widgets.backend.pageElements.headerSearchResult', ['closeSearchLink' => route('backend.report.pointlog') ])
	</br>
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th class="col-md-3">Nama</th>
									<th class="col-md-2">Kredit</th>
									<th class="col-md-2">Tanggal</th>
									<th class="col-md-4">Catatan</th>
									<th class="col-md-1">Kontrol</th>
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
										<td>{{ $data['user']['name'] }}</td>
										<td>
											{{$data['debit'] - $data['credit']}}
										</td>
										<td>{{ $data['created_at'] }}</td>
										<td>{{ $data['notes'] }}</td>
										<td>
											<a href="{{ route('backend.data.product.show', $data['id']) }}">Detail</a>                                          
										</td>    
									</tr>       
									<?php $ctr += 1; ?>                     
									@endforeach 
									@include('widgets.pageElements.formModal1', array('modal_id'=>'trans_del', 'modal_content' => 'pages.backend.data.transaction.delete'))
								@endif
							</tbody>							
						<table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop