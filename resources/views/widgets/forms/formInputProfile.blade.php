<form role="form" style="padding-right:inherit;padding-left:inherit;">
    <div class="row">
        <div class="col-sm-4 col-xs-4">                             
            <div class="row">
                <div class="col-md-12">
                    <img style ="width:100%;" src="https://placeholdit.imgix.net/~text?txtsize=30&txt=320%C3%97150&w=320&h=320" alt="Profile" clas="img-responsive">
                </div>
            </div>
        </div>
        <div class="col-sm-8 col-xs-8"> 
            <div class="row">
                <p style="font-size:12px;">Click this button bellow to browse image for your profile</p>
                <p style="font-size:12px;">* Max image size : 1,5 MB</p>
            </div>
            <div class="row">
                <button type="button" class="btn btn-md btn-xs btn-default">browse</button>
            </div>
        </div>
    </div>
    </br>     
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