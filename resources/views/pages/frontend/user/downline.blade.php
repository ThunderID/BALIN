@inject('points', 'App\Models\PointLog')
<?php
	$downlines 		= $points->referenceid(Auth::user()->id)->referencetype('App\Models\User')->with(['user'])->paginate();
?>

<div class="row m-t-n" style="background-color:#000; color:#fff; letter-spacing: 0.1em;">
	<div class="col-sm-1">
		<h5>No</h5>
	</div>
	<div class="col-sm-3">
		<h5>Tanggal</h5>
	</div>
	<div class="col-sm-8">
		<h5>Downline</h5>
	</div>
</div>
@forelse($downlines as $key => $value)
	<div class="row m-t-sm @if($key+1!=count($downlines)) border-bottom @endif">
		<div class="col-sm-1"> 
			<p class="text-left">
				{!!(($key)+1)!!}
			</p>
		</div>
		<div class="col-sm-3">
			<p class="text-left">
				@date_indo($value->created_at)
			</p>
		</div>
		<div class="col-sm-8">
			<p class="text-left">
				{{ $value['user']['name'] }}
			</p>
		</div>
	</div>
@empty
	<div class="row m-t-sm">
		<div class="col-sm-12">
			<p class="text-center"> Tidak ada data </p>
		</div>
	</div>
@endforelse

<div class="row">
    <div class="col-md-12" style="text-align:right;">
        {!! $downlines->appends(Input::all())->render() !!}
    </div>
</div>