@inject('points', 'App\Models\PointLog')
<?php
	$pointlogs 		= $points->CurrentPoint(Auth::user()->id)->orderby('created_at', 'desc')->paginate();
	$balance 		= Auth::user()->balance;
?>
<h4 class="hidden-xs" style="margin-top:-50px;margin-bottom:50px;">Point Balin Anda Sekarang <span style="@if($balance >= 0) color:green; @endif"> @money_indo($balance)</span></h4>

<div class="col-md-12 col-sm-12 hidden-xs">
	<div class="row m-t-n" style="background-color:#000; color:#fff; letter-spacing: 0.1em;">
		<div class="col-sm-2">
			<h5>Tanggal</h5>
		</div>
		<div class="col-sm-2">
			<h5>Total</h5>
		</div>
		<div class="col-sm-2">
			<h5>Expired</h5>
		</div>
		<div class="col-sm-6">
			<h5>Info</h5>
		</div>
	</div>
</div>

@forelse($pointlogs as $key => $value)
	<?php         
		$datetrans                          = Carbon::now();

		if($value['expired_at']->lt($datetrans))
		{
			$is_expired						= true;
		}
		else
		{
			$is_expired 					= false;
		}
	?>

	<div class="col-md-12 col-sm-12 hidden-xs">
		<div class="row m-t-sm @if($key+1!=count($pointlogs)) border-bottom @endif">
			<div class="col-sm-2"> 
				<p class="text-left">
					@datetime_indo($value['created_at']) 
				</p>
			</div>
			<div class="col-sm-2">
				<p class="text-center">
					@if(!$is_expired)
						@money_indo(($value['prev_amount'] + $value['amount']))
					@else
						<i>Expired</i>
					@endif
				</p>
			</div>
			<div class="col-sm-2">
				<p class="text-center">
					<i>@date_indo($value['expired_at'])</i>
				</p>
			</div>
			<div class="col-sm-6">
				<p class="text-left">
					Point anda
					@if($value['amount'] >= 0)
						ditambahkan
					@else
						dikurangkan 
					@endif
					@money_indo(abs($value['amount']))
					untuk 
					{!!$value['notes']!!}
				</p>
			</div>
		</div>
	</div>
	<!-- MOBILE -->
	<div class="hidden-lg hidden-md hidden-sm col-xs-12">
		<div class="row m-t-n" style="letter-spacing: 0.1em;">
			<div class="row m-t-lg">
				<div class="col-xs-12">
						<div class="row m-b-md">
							<div class="col-xs-12 text-center">
								<p style="font-size:12px; margin-bottom: 5px;">@datetime_indo($value['created_at'])</p>
								@if($value['amount'] >= 0)
									<p style="font-size:16px; margin-bottom: 2px; color:green;"><span>(+)</span> &nbsp;@money_indo(abs($value['amount']))</p>
								@else
									<p style="font-size:16px; margin-bottom: 2px; color:red;"><span>(-)</span> &nbsp;@money_indo(abs($value['amount']))</p>
								@endif
								<p style="font-size:9px; margin-bottom: 0px;">Poin Anda sekarang</p>
								<p style="margin-top: 0px; margin-bottom: 0px;">
									@if(!$is_expired)
										@money_indo(($value['prev_amount'] + $value['amount']))
									@else
										<i>Expired</i>
									@endif
								</p>
								<h4 style="font-size:16px; margin-top: 4px; margin-bottom: 5px">{!!$value['notes']!!}</h4>
								<p style="font-size:9px;">expired on</br> <span style="font-size:10px;">@date_indo($value['expired_at'])</span></p>
							</div>					
						</div>	
				</div>
			</div>
		</div>
	</div>
@empty
	<div class="col-md-12 col-sm-12 hidden-xs">
		<div class="row m-t-sm">
			<div class="col-sm-12">
				<p class="text-center"> Tidak ada data </p>
			</div>
		</div>
	</div>
	<div class="col-xs-12 hidden-lg hidden-sm hidden-md">
		<p class="text-center"> Tidak ada data </p>
	</div>
@endforelse


<div class="col-md-12 hollow-pagination text-right">
	<div class="row">
		{!! $pointlogs->render() !!}
	</div>
</div>