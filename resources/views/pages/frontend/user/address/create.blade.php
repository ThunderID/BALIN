@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-sm-12">
			<h3 class="page-title m-t-0">{{$title}} <small>{{$subtitle}}</small></h3>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>

	<div class="row">
		<div class="col-sm-12">
			@if(!is_null($id))
			    {!! Form::open(['url' => route('frontend.profile.address.update', $id), 'method' => 'PATCH']) !!}
			@else
			    {!! Form::open(['url' => route('frontend.profile.address.store'), 'method' => 'POST']) !!}
			@endif
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="phone">Nomor Telepon</label>
							{!! Form::text('phone', $address['phone'], ['class' => 'form-control hollow mod_name', 'required' => 'required', 'tabindex' => '1', 'placeholder' => 'Masukkan nomor telepon'] ) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="zipcode">Kode Pos</label>
							{!! Form::text('zipcode', $address['zipcode'], ['class' => 'form-control hollow mod_email', 'tabindex' => '2', 'placeholder' => 'Masukkan kode pos']) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="address">Alamat</label>
							 {!! Form::textarea('address', $address['address'], ['class' => 'form-control hollow mod_dob', 'required' => 'required', 'tabindex' => '3', 'style' => 'resize:none', 'rows' => '5'] ) !!}
						</div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-12">
						</br>
						<div class="form-group text-right">
							<button type="submit" class="btn-hollow hollow-black" tabindex="4">Simpan</button>
						</div>        
					</div>        
				</div>    
			{!! Form::close() !!}
		</div>
	</div>
@stop