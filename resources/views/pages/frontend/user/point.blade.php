@inject('points', 'App\Models\PointLog')
<?php
	$pointlogs 		= $points->userid(Auth::user()->id)->orderby('expired_at', 'desc')->paginate();
?>
@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-sm-12">
			<h3 class="page-title m-t-0">{{$title}}</h3>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Tanggal</th>
						<th>Debit</th>
						<th>Kredit</th>
						<th>Saldo</th>
						<th>Catatan</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$amount = (Input::has('amount') ? Input::get('amount') : 0);
						if(!Input::has('page') || Input::get('page')=='1')
						{
							$amount 	= 0;
						}
					?>
					@forelse($pointlogs as $key => $value)
					<?php         
						$datetrans                          = Carbon::now();

        				if($value->expired_at->lt($datetrans))
        				{
	        				$is_expired						= true;
        				}
        				else
        				{
        					$is_expired 					= false;
        				}

        				if(!$is_expired)
        				{
							$amount							= $amount + $value->amount;
        				}
						$number = (($pointlogs->currentPage() - 1) * $pointlogs->perPage())+1;
					?>
						<tr>
							<td class="text-center">{!!(($key)+$number)!!}</td>
							<td> @date_indo($value->created_at) </td>
							@if($value->amount >= 0)
								<td>@money_indo($value->amount)</td>
							@else
								<td></td>
							@endif
							@if($value->amount < 0)
								<td>@money_indo($value->amount)</td>
							@else
								<td></td>
							@endif
							@if(!$is_expired)
								<td>@money_indo($amount)</td>
							@else
								<td><i>Expired</i></td>
							@endif
							<td>
								{!!$value->notes!!}
								<br/>
								<i>Expired @ @date_indo($value->expired_at)</i>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6"> Tidak ada data </td>
						</tr>
					@endforelse
				</tbody>
			</table>
			<div class="row">
                <div class="col-md-12 hollow-pagination text-right">
                    {!! $pointlogs->appends(['amount' => $amount])->render() !!}
                </div>
            </div>
		</div>
	</div>
@stop