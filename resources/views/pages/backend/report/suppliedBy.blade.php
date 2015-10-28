@inject('datas', 'App\Models\product')
<?php
$datas 			= $datas
					->Suppliers(true)
					->paginate()
					;									
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th class="col-md-1 text-center">Sku</th>
									<th class="col-md-5">Nama Produk</th>
									<th class="col-md-5">Nama Supplier</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$nop = ($datas->currentPage() - 1) * 15;
									$ctr = 1 + $nop;
								?> 
								@if (count($datas) == 0)
									<tr>
										<td colspan="4" class="text-center">
											Tidak ada data
										</td>
									</tr>
								@else                                                                 
									@foreach ($datas as $data)
									<tr>
										<td class="text-center">{{ $ctr }}</td>
										<td class="text-center">{{ $data['sku'] }}</td>
										<td>{{ $data['name'] }} <a href="{{ route('backend.data.product.show', $data['id']) }}">(Detail)</a></td>
										<td>
											@foreach($data->transactions as $key => $value)
												<li>
													{!! $value->supplier->name !!} <a href="{{ route('backend.data.supplier.show', $data['id']) }}">(Detail)</a>
												</li>
											@endforeach
										</td>
									</tr>       
									<?php $ctr += 1; ?>                     
									@endforeach 
									@include('widgets.pageelements.formModal1', array('modal_id'=>'trans_del', 'modal_content' => 'pages.backend.data.transaction.delete'))
								@endif
							</tbody>							
						<table>
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