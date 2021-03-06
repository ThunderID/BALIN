@inject('data', 'App\Models\Transaction')
<?php 
?>

@extends('template.backend.layout') 

@section('content')
	<div class="row">
		<div class="col-md-7 col-sm-5 col-xs-12">
			<table>
				<tbody>
					<tr>
						<td><strong>{{$transaction['supplier']['name']}}</strong></td>
					</tr>
					<tr>
						<td>{{$transaction['supplier']['address']['phone']}}</td>
					</tr>
					<tr>
						<td>{{$transaction['supplier']['address']['address']}}, {{$transaction['supplier']['address']['zipcode']}}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<div class="clearfix row">
				&nbsp;
			</div>

			<div class="row">
				<div class="col-xs-5">
					<strong>Invoice ID</strong>
				</div>
				<div class="col-xs-7 text-left">
					{{$transaction['ref_number']}}
				</div>
			</div>

			<div class="row">
				<div class="col-xs-5">
					<strong>Invoice Date</strong>
				</div>
				<div class="col-xs-7 text-left">
					@date_indo($transaction['transact_at'])
				</div>
			</div>

		</div>
		<div class="col-md-5 col-sm-7 hidden-xs">
			<table>
				<tbody>
					<tr class="row">
						<td class="col-sm-6 text-left"><strong>Invoice ID</strong></td>
						<td class="text-left"> {{$transaction['ref_number']}} </td>
					</tr>
					<tr class="row">
						<td class="col-sm-6 text-left"><strong>Invoice Date</strong></td>
						<td class="text-left">@date_indo($transaction['transact_at'])</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Item#</th>
						<th>Description</th>
						<th>Qty</th>
						<th>Unit Price</th>
						<th>Discount</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php $amount = 0;?>
					@forelse($transaction['transactiondetails'] as $key => $value)
						<?php $amount = $amount + (($value['price'] - $value['discount']) * $value['quantity']);?>
						<tr>
							<td>{!!($key+1)!!}</td>
							<td>
								<strong> UPC </strong>{{$value['varian']['product']['upc']}} <br/>
								<strong> SKU </strong>{{$value['varian']['sku']}}
							</td>
							<td> {{$value['varian']['product']['name']}} {{$value['varian']['size']}}</td>
							<td class="text-right"> {{$value['quantity']}} </td>
							<td class="text-right"> @money_indo($value['price']) </td>
							<td class="text-right"> @money_indo($value['discount']) </td>
							<td class="text-right"> @money_indo((($value['price'] - $value['discount']) * $value['quantity'])) </td>
						</tr>
					@empty
						<tr>
							<td colspan="7"> Tidak ada data </td>
						</tr>
					@endforelse
					@if($transaction['transactiondetails'])
						<tr>
							<td colspan="5"></td>
							<td><strong>Ongkos Kirim</strong></td>
							<td class="text-right">@money_indo($transaction['shipping_cost'])</td>
						</tr>
						<tr>
							<td colspan="5"></td>
							<td><strong>Total</strong></td>
							<td class="text-right">@money_indo(($amount + $transaction['shipping_cost']))</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop