@extends('template.frontend.layout')

@section('content')
	<div class="container-fluid page-join" style="background-color: rgba(0, 0, 0, 0.62);">
		<div class="container">
			<div class="row" style="padding-top:60px">
				<div class="col-md-4 col-md-offset-4">
					<div class="row panel-hollow panel-default p-xs" style="margin-top:28%">
						<div class="col-md-12">
							{!! Form::open(['url' => route('frontend.post.forgot'), 'method' => 'POST']) !!}
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="">Password</label>
											{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Masukkan password', 'tabindex' => '1']) !!}
											<span class="help-block m-b-none">* Biarkan kosong jika tidak ingin mengubah password</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="">Konfirmasi Password</label>
											{!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Masukkan konfirmasi password', 'tabindex' => '2']) !!}
										</div>
									</div>
								</div>
								{!! Form::hidden('email', $email) !!}

								<div class="row">
									<div class="col-md-12">
										</br>
										<div class="form-group text-right">
											<button type="submit" class="btn btn-md btn-primary" tabindex="3">Simpan</button>
										</div>        
									</div>        
								</div>    
							{!! Form::close() !!}
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
	$('document').ready(function() {
		$('body').attr('style', 'background-image: url("http://localhost:8000/Balin/web/image/2.jpg")');
		$('.page-join').height(($(window).height())+$('footer.footer').height());
	});
@stop