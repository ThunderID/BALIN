<form role="form" style="padding-right:inherit;padding-left:inherit;">
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" class="form-control" id="name" required>
    </div>	
    <div class="form-group">
        <label for="gender">Gender</label>
		<select class="form-control" id="gender">
			<option value="" disabled selected>Select Gender</option>
		    <option value="Male">Male</option>
		    <option value="Female">Female</option>
		</select>
    </div>	
    <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" class="form-control" id="dob" required>
    </div>	        				
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" id="phone" required>
        <p class="pull-right">Ex : 081234567890</p>
    </div>	    		    		    			
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" required>
        <p class="pull-right">Ex : Jl. Green 12, West Estate</p>
    </div>	
    <div class="form-group">
        <label for="postal">Postal Code</label>
        <input type="text" class="form-control" id="postal" required>
    </div>
    <div class="form-group">
        <label for="province">Provincee</label>
        <input type="text" class="form-control" id="province" required>
    </div>
    <div class="form-group">
        <label for="city">City</label>
        <input type="text" class="form-control" id="city" required>
    </div>
    <div class="form-group">
        <label for="country">Country</label>
        <input type="text" class="form-control" id="country" required>
    </div>    
    <div class="form-group">
        <label for="type">Profile Type</label>
        <select class="form-control" id="gender">
            <option value="" disabled selected>Select Profile Type</option>
            <option value="Admin">Admin</option>
            <option value="Customer">Customer</option>
        </select>
    </div>       
	</br>
	<div class="form-group">
	    <button type="submit" class="btn btn-md btn-info">Save Profile</button>
	</div>
</form>	