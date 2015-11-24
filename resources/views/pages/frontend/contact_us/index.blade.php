@extends('template.frontend.layout')
@section('content')    
	<div class="container mt-75 mobile-m-t-10">
		<div class="row">
			<div class="col-md-7 col-sm-7 col-xs-12">
				@include('widgets.breadcrumb')
			</div>
		</div>
		<div class="row">
			<div class="container">
				<div class="col-md-6 colsm-6 col-xs-12  panel">
					<div class="row">
						<div class="col-md-12">
							<h3>Contact Us</h3>

							@include('widgets.backend.pageelements.alertbox')

							{!! Form::open(['url' => route('contactus.dosubmit')]) !!}
							    <div class="form-group">
							        <label for="name" style="font-weight:400">Nama *</label>
									{!! Form::text('name', null, [
												'class'         => 'form-control hollow', 
												'tabindex'      => '1', 
												'placeholder'   => 'Masukkan nama anda'
									]) !!}
							    </div>
							    <div class="form-group">
							        <label for="email" style="font-weight:400">Email *</label>
									{!! Form::email('email', null, [
												'class'         => 'form-control hollow', 
												'tabindex'      => '2', 
												'placeholder'   => 'Masukkan email anda'
									]) !!}
							    </div>

							    <div class="form-group">
								    <label for="message" style="font-weight:400">Pesan *</label>
									{!! Form::textarea('message',null, [
												'class'         => 'form-control hollow', 
												'placeholder'   => 'Masukkan pesan anda',
												'rows'          => '5',
												'tabindex'      => '3',
												'style'         => 'resize:none;',
									]) !!}
								</div>
								<p class="t-xs" style="color:#666">
									* wajib untuk diisi.
								</p>
								<div class="clearfix">&nbsp;</div>
								<div class="form-group">
								    <button type="submit" class="btn-hollow hollow-black-border " tabindex="4">Kirim</button>
								</div>
								<div class="clearfix">&nbsp;</div>
							{!! Form::close() !!}							
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 hide-xs">
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
@stop