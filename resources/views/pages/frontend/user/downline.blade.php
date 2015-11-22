@inject('points', 'App\Models\PointLog')
<?php
	$downlines 		= $points->referenceid(Auth::user()->id)->referencetype('App\Models\User')->with(['reference'])->paginate();
?>

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">Tanggal</th>
						<th class="text-center">Downline</th>
					</tr>
				</thead>
				<tbody>
					@forelse($downlines as $key => $value)
						<tr>
							<td>{!!(($key)+1)!!}</td>
							<td> @date_indo($value->created_at) </td>
							<td> {{$value['reference']['name']}} </td>
						</tr>
					@empty
						<tr>
							<td class="text-center" colspan="3"> Tidak ada data </td>
						</tr>
					@endforelse
				</tbody>
			</table>
			<div class="row">
                <div class="col-md-12" style="text-align:right;">
                    {!! $downlines->appends(Input::all())->render() !!}
                </div>
            </div>
		</div>
	</div>