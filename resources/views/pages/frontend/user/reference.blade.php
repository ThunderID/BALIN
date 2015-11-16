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
		    {!! Form::open(['url' => route('frontend.profile.reference.post'), 'method' => 'POST']) !!}
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="referral_code">Referral Code</label>
							{!! Form::text('referral_code', '', ['class' => 'form-control hollow mod_referral_code', 'required' => 'required', 'tabindex' => '1', 'placeholder' => 'Masukkan nama referral code referensi'] ) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						</br>
						<div class="form-group text-right">
							<button type="submit" class="btn-hollow hollow-black" tabindex="2">Simpan</button>
						</div>        
					</div>        
				</div>    
			{!! Form::close() !!}
		</div>
	</div>
@stop