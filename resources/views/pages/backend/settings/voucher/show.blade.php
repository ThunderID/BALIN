@inject('data', 'App\Models\Voucher')

<?php 
$data = $data::id($id)->with(['transactions', 'transactions.user'])->first();
?>

@extends('template.backend.layout')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-capitalize">Informasi Voucher</h3>
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Kode Voucher<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p class="">{{ $data['code'] }}</p>
				</div>
			</div> 
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Jumlah Penggunaan<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p>{{ count($data['transactions']) }}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 text-left">
					<p class="text-capitalize">Sisa Quota<span class="pull-right">:</span></p>
				</div>
				<div class="col-md-8">
					<p>{{ $data['quota'] }} <a href="{{route('backend.settings.quota.index', $id)}}">custom quota</a></p>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-capitalize">Data Transaksi dengan voucher ini</h3>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th class="col-md-2">#</th>
					<th class="text-center col-md-3">Tanggal</th>
					<th class="text-center col-md-3">Amount</th>
					<th class="text-center col-md-3">Kostumer</th>
				</tr>
			</thead>
			<tbody>
				@if (count($data['transactions']) == 0)
				<tr>
					<td colspan="5">
						<p class="text-center">Tidak ada data</p>
					</td>
				</tr>					
				@else
					@foreach($data['transactions'] as $ctr => $transaction)
						<tr>
							<td>{{ $ctr+1 }}</td>
							<td><a href="{{route('backend.data.transaction.show', ['id' => $transaction['transaction_id'], 'type' => 'sell'])}}">{{$transaction['ref_number']}}</a></td>
							<td>@date_indo($transaction['transact_at'])</td>
							@if($data['type']=='free_shipping_cost')
								<td class="text-right">@money_indo($transaction['referral_discount'])</td>
							@else
								<td class="text-right">@money_indo($data['value'])</td>
							@endif
							<td>{{$transaction['user']['name']}}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>  
@stop