@extends('template.campaign.layout_campaign')
@section('content')
	<div class="container-fluid softlaunch-sign-up" style="">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-5 col-md-offset-7 col-lg-5 col-lg-offset-7">
				<div class="form-softlaunch p-sm" style="margin-top: 34%;">
					<h3 class="m-t-xs">REDEEM CODE</h3>
					@include('widgets.alerts')
					{!! Form::open(['url' => route('frontend.promo.post')]) !!}
						<div class="form-group">
							{!! Form::text('voucher', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Code Anda', 'required']) !!}
						</div>
						<div class="form-group text-left">
						    <button type="submit" class="btn-hollow hollow-black-border">Redeem</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>	
	</div>
@stop