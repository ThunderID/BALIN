@inject('datas', 'App\Models\QuotaLog')
<?php 
$datas 			= $datas->voucherid($vou_id)->paginate();
?>


@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-8 col-sm-4 hidden-xs">
					<a class="btn btn-default" href="{{ URL::route('backend.settings.quota.create', ['vou_id' => $vou_id]) }}"> Data Baru </a>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12">
					<a class="btn btn-default btn-block" href="{{ URL::route('backend.settings.quota.create', ['vou_id' => $vou_id]) }}"> Data Baru </a>
				</div>
				<div class="col-md-4 col-sm-8 col-xs-12">
					{!! Form::open(array('route' => 'backend.settings.voucher.show', 'method' => 'get' )) !!}
						<div class="row">
							<div class="col-md-2 col-sm-3 hidden-xs">
							</div>
							<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
								{!!Form::hidden('vou_id', Input::get('vou_id'))!!}
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
			@include('widgets.backend.pageelements.headersearchresult', ['closeSearchLink' => route('backend.settings.quota.index') ])
			</br> 
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>No.</th>
									<th class="text-center">Tanggal</th>
									<th class="text-center">Debit</th>
									<th class="text-center">Kredit</th>
									<th class="text-center">Saldo</th>
									<th class="text-center">Catatan</th>
									<th class="text-center">Kontrol</th>
								</tr>
							</thead>
							<tbody>
								@if(count($datas) == 0)
									<tr>
										<td colspan="7" class="text-center">
											Tidak ada data
										</td>
									</tr>
								@else                                                                 
									<?php
										$nop = ($datas->currentPage() - 1) * 15;
										$ctr = 1 + $nop;
										$amount = (Input::has('amount') ? Input::get('amount') : 0);
										if(!Input::has('page') || Input::get('page')=='1')
										{
											$amount 	= 0;
										}
									?> 
									@foreach($datas as $data)
									<?php
										$amount 		= $amount + $data['amount'];
									?>
									<tr>
										<td>{{$ctr}}</td>
										<td class="text-center">@date_indo($data['created_at'])</td>
										<td class="text-center">
											@if($data['amount'] > 0)
												{!!$data['amount']!!}
											@endif
										</td>
										<td class="text-center">
											@if($data['amount'] < 0)
												{!!$data['amount']!!}
											@endif
										</td>
										<td class="text-center">{{$amount}}</td>                                                                               
										<td class="text-center">{{$data['notes']}}</td>                                                                               
										<td class="text-center">
											<a href="{{ URL::route('backend.settings.quota.edit', ['vou_id' => $vou_id, 'id' => $data['id']]) }}"> Edit </a>, 
											<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#quota_del"
												data-id="{{ $data['id'] }}"
												data-title="Hapus Pengaturan Quota {{$data['voucher']['name']}}"
												data-action="{{ route('backend.settings.quota.destroy', ['vou_id' => $vou_id, 'id' => $data['id']]) }}">
												Hapus
											</a>  
										</td>    
									</tr>       
									<?php $ctr += 1; ?>                     
									@endforeach 
									@include('widgets.pageelements.formmodaldelete', [
											'modal_id'      => 'quota_del', 
											'modal_route'   => route('backend.settings.quota.destroy', 0)
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
                    	{!! $datas->appends(['amount' => $amount])->render() !!}
					</div>
				</div>
			@endif
		</div>
	</div>
@stop