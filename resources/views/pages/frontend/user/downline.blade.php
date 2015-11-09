@inject('points', 'App\Models\PointLog')
<?php
	$downlines 		= $points->referenceid(Auth::user()->id)->referencetype('App\Models\User')->with(['reference'])->paginate();
?>
@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-sm-12">
			<h3 class="page-title m-t-lg">{{$title}}</h3>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Downline</th>
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
							<td colspan="3"> Tidak ada data </td>
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
@stop