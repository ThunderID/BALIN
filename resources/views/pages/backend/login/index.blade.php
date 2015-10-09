@extends('template.backend.layout_auth') 

@section('content')
	{!! Form::open(['class' => 'm-t']) !!}	
		<div class="form-group">
				<input type="email" class="form-control" placeholder="Username" required="">
		</div>
		<div class="form-group">
				<input type="password" class="form-control" placeholder="Password" required="">
		</div>
		<button type="submit" class="btn btn-primary block full-width m-b">Login</button>

		<a href="#"><small>Forgot password?</small></a>
	{!! Form::close() !!}
@stop