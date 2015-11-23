@inject('points', 'App\Models\PointLog')
<?php
	$pointlogs 		= $points->userid(Auth::user()->id)->orderby('created_at', 'asc')->paginate();
?>
	<div class="row m-t-n" style="background-color:#000; color:#fff; letter-spacing: 0.1em;">
		<div class="col-sm-2">
			<h5>Tanggal</h5>
		</div>
		<div class="col-sm-3">
			<h5>Status</h5>
		</div>
		<div class="col-sm-2">
			<h5>Pointku</h5>
		</div>
		<div class="col-sm-3">
			<h5>Info</h5>
		</div>
		<div class="col-sm-2">
			<h5>Expired</h5>
		</div>
	</div>

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
		<div class="row m-t-sm @if($key+1!=count($pointlogs)) border-bottom @endif">
			<div class="col-sm-2"> 
				<p class="text-left">
					@datetime_indo($value->created_at) 
				</p>
			</div>
			<div class="col-sm-3">
				<p class="text-left">
					Point anda
					@if($value->amount >= 0)
						ditambahkan
					@else
						dikurangkan 
					@endif
					@money_indo($value->amount)
				</p>
			</div>
			<div class="col-sm-2">
				<p class="text-center">
					@if(!$is_expired)
						@money_indo($amount)
					@else
						<i>Expired</i>
					@endif
				</p>
			</div>
			<div class="col-sm-3">
				<p class="text-left">
					{!!$value->notes!!}
				</p>
			</div>
			<div class="col-sm-2">
				<p class="text-center">
					<i>@date_indo($value->expired_at)</i>
				</p>
			</div>
		</div>
	@empty
		<div class="row m-t-sm">
			<div class="col-sm-12"> Tidak ada data </div>
		</div>
	@endforelse
	
	<div class="row">
		<div class="col-md-12 hollow-pagination text-right">
			{!! $pointlogs->appends(['amount' => $amount])->render() !!}
		</div>
	</div>