@inject('address', 'App\Models\Address')
<?php
	$addresses 		= $address->ownerid(Auth::user()->id)->ownertype('App\Models\User')->paginate();
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
						<th>Phone</th>
						<th>Zipcode</th>
						<th>Address</th>
					</tr>
				</thead>
				<tbody>
					@forelse($addresses as $key => $value)
						<tr>
							<td>{!!(($key)+1)!!}</td>
							<td> {{$value['phone']}} </td>
							<td> {{$value['zipcode']}} </td>
							<td> {{$value['address']}} </td>
						</tr>
					@empty
						<tr>
							<td colspan="4"> Tidak ada data </td>
						</tr>
					@endforelse
				</tbody>
			</table>
			<div class="row">
                <div class="col-md-12" style="text-align:right;">
                    {!! $addresses->appends(Input::all())->render() !!}
                </div>
            </div>
		</div>
	</div>
@stop