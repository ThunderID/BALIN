@inject('points', 'App\Models\PointLog')
<?php
	$downlines 		= $points->referenceid(Auth::user()->id)->referencetype('App\Models\User')->with(['user'])->paginate();
?>

<div class="row hidden-xs">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h4 class="m-b-md"><strong>Sisa Kuota Referal Anda : {{ Auth::user()->quota }}</strong></h4>
	</div>
</div>
<div class="row border-bottom hidden-sm hidden-md hidden-lg">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h4 class="m-t-sm m-b-md"><strong>Sisa Kuota Referal Anda : {{ Auth::user()->quota }}</strong></h4>
	</div>
</div>
<div class="col-md-12 col-sm-12 hidden-xs">
	<div class="row m-t-n" style="background-color:#000; color:#fff; letter-spacing: 0.1em;">
		<div class="col-sm-1">
			<h5>No</h5>
		</div>
		<div class="col-sm-3">
			<h5>Tanggal</h5>
		</div>
		<div class="col-sm-8">
			<h5>Referal Anda</h5>
		</div>
	</div>
</div>

<div class="col-md-12 col-sm-12 hidden-xs">
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
</div>


<!-- MOBILE -->
<div class="hidden-lg hidden-md hidden-sm col-xs-12">
	<div class="row m-t-n" style="letter-spacing: 0.1em;">
		<div class="row m-t-lg">
			<div class="col-xs-12">
				@forelse($downlines as $key => $value)
					<p class="text-center"> {!!(($key)+1)!!} . {{ $value['user']['name'] }} </br><span style="font-size:12px !important;">(@date_indo($value->created_at))</span> </p>
				@empty
					<p class="text-center"> Tidak ada data </p>
				@endforelse
			</div>
		</div>
	</div>
</div>


<div class="col-md-12" style="text-align:center;">
	<div class="row">
        {!! $downlines->appends(Input::all())->render() !!}
    </div>
</div>