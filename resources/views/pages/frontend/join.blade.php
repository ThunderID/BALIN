@extends('template.frontend.layout')

@section('content')
	<div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <h3>Sign In</h3>

                        <div class="row carousel-holder">
		                </div>

		                <div class="row">
		                	<div class="col-md-12">
								<form role="form">
								    <div class="form-group">
								        <label for="email">Email address:</label>
								        <input type="email" class="form-control" id="email">
								    </div>
								    <div class="form-group">
									    <label for="pwd">Password:</label>
									    <input type="password" class="form-control" id="pwd">
									</div>
									<div class="checkbox">
									    <label><input type="checkbox"> Remember me</label>
									</div>
									<div class="form-group">
									    <button type="submit" class="btn btn-default">Submit</button>
									</div>
								</form>
			                </div>
		                </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <h3>Sign Up</h3>

                        <div class="row carousel-holder">
		                </div>

		                <div class="row">
		                	<div class="col-md-12">
								<div class="form-group">
									<p>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				                	</p>
								</div>		
		                        <div class="row carousel-holder">
				                </div>								                	
								<div class="form-group">
									<button type="submit" class="btn btn-default">Facebook</button>
									<button type="submit" class="btn btn-default">Twitter</button>
									<button type="submit" class="btn btn-default">Email</button>
								</div>		                	
							</div>		                	
		                </div>                        
                    </div>
                </div>


            </div>
        </div>

	</div>
@stop