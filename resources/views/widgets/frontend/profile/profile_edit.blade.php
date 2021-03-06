<div class="row">
	<div class="col-md-12">
		<h3>Change Profile</h3>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="row m-b-lg">
			<div class="col-md-6">
				<form role="form" style="padding-right:inherit;padding-left:inherit;">
					<div class="row">
						<div class="col-sm-5 col-xs-5">                             
							<div class="row">
								<div class="col-md-12">
									{!! HTML::image('Balin/web/image/tmp_avatar.png', 'avatar', ['class' => 'img-responsive']) !!}
								</div>
							</div>
						</div>
						<div class="col-sm-7 col-xs-7"> 
							<div class="row">
								<p style="font-size:12px;">Click this button bellow to browse image for your profile</p>
								<p style="font-size:12px;">* Max image size : 1,5 MB</p>
							</div>
							<div class="row">
								<button type="button" class="btn-hollow hollow-black btn-hollow-xs">browse</button>
							</div>
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="clearfix">&nbsp;</div>
					<div class="row">
						<div class="col-sm-12 col-xs-12">
						
							<div class="form-group">
								<label for="name">Full Name</label>
								<input type="text" class="form-control hollow" id="name" required>
							</div>  
							<div class="form-group">
								<label for="gender">Gender</label>
								<select class="form-control hollow" id="gender">
									<option value="" disabled selected>Select Gender</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>  
							<div class="form-group">
								<label for="dob">Date of Birth</label>
								<input type="date" class="form-control hollow" id="dob" required>
							</div>                          
							<div class="form-group">
								<label for="email">Email address</label>
								<input type="email" class="form-control hollow" id="email" required>
							</div>
							<div class="form-group">
								<label for="phone">Phone Number</label>
								<input type="text" class="form-control hollow" id="phone" required>
								<span class="info">Ex : 081234567890</span>
							</div>                                          
							<div class="form-group">
								<label for="address">Address</label>
								<input type="text" class="form-control hollow" id="address" required>
								<span class="info">Ex : Jl. Green 12, West Estate</span>
							</div>  
							<div class="form-group">
								<label for="postal">Postal Code</label>
								<input type="text" class="form-control hollow" id="postal" required>
							</div>
							<div class="form-group">
								<label for="province">Provincee</label>
								<input type="text" class="form-control hollow" id="province" required>
							</div>
							<div class="form-group">
								<label for="city">City</label>
								<input type="text" class="form-control hollow" id="city" required>
							</div>
							<div class="form-group">
								<label for="country">Country</label>
								<input type="text" class="form-control hollow" id="country" required>
							</div>    
							<div class="form-group">
								<label for="type">Profile Type</label>
								<select class="form-control hollow" id="gender">
									<option value="" disabled selected>Select Profile Type</option>
									<option value="Admin">Admin</option>
									<option value="Customer">Customer</option>
								</select>
							</div>       
							</br>
							<div class="form-group">
								<button type="submit" class="btn-hollow hollow-black">Save Profile</button>
							</div>
						</div>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>