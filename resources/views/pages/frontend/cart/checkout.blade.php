@extends('template.frontend.layout')

@section('content')
	<div class="container mt-75">
		<div class="row">
			<div class="col-lg-12">
				@include('widgets.pageelements.pagetitle', array('pagetitle' => 'Checkout'))
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-sm-12">
			    {!! Form::open(['url' => route('frontend.profile.update'), 'method' => 'POST']) !!}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="name">Alamat Sebelumnya</label>
								<select class="form-control" name="address_id">
									<option value="0"></option>
									@foreach($addresses as $key => $value)
										<option value={{$value['id']}}>{{$value['receiver_name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Alamat</label>
								{!! Form::textarea('address', null, [
										'class' 		=> 'form-control transaction-input-address',
										'rows'      => '2',
										'tabindex'  => '3',
										'style'     => 'resize:none;',
								]) !!}
							</div>
							<div class="form-group">
								<label for="">Kode Pos</label>
								{!! Form::input('number', 'postal_code', null, [
										'class' 		=> 'form-control transaction-input-postal-code',
								]) !!}
							</div>
							<div class="form-group">
								<label for="">No. Tlp</label>
								{!! Form::input('number', 'phone', null, [
										'class' 		=> 'form-control transaction-input-phone',
								]) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							</br>
							<div class="form-group text-right">
								<button type="submit" class="btn-hollow hollow-black" tabindex="7">Simpan</button>
							</div>        
						</div>        
					</div>    
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop

@section('script')

@stop
