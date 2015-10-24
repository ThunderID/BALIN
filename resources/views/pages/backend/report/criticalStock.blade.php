@inject('datas', 'App\Models\Stock')
<?php
$datas 			= $datas
					->OnCriticalStock(true)
					->with('product')
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
									<th class="col-md-2 text-center">Stock Display</th>
									<th class="col-md-2 text-center">Stock On Hold</th>
									<th class="col-md-2">Kontrol</th>
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
										<td class="text-center">{{ $data['product']['sku'] }}</td>
										<td>{{ $data['product']['name'] }}</td>
										<td class="text-center">{{ $data['current_stocks'] }} </td>
										<td class="text-center">{{ $data['on_hold_stocks'] }} </td>
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