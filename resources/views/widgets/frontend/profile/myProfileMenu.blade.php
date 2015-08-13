<div class="row">
	<div class="col-md-12">
		<h3>Orders</h3>
	</div>
</div>

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Submenu 1', 'linkDirection' => '#'))

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Submenu 2', 'linkDirection' => '#'))

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Submenu 3', 'linkDirection' => '#'))

<div class="row">
	<div class="col-md-12">
    	<h3>Account</h3>
	</div>
</div>

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Profile Details', 'linkDirection' =>  route('frontend.profile.index') ))

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Change Profile', 'linkDirection' =>  route('frontend.profile.changeProfile') ))

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Change Password', 'linkDirection' =>  route('frontend.profile.changePassword') ))
  
<div class="row">
	<div class="col-md-12">
    	<h3>Membership</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    	<a href="{{ route('frontend.profile.membershipDetail') }}" style="color:blue;">Membership Details</a>
	</div>
</div> 
<div class="row">
	<div class="col-md-12">
    	<a href="#" style="color:blue;">Submenu 2</a>
	</div>
</div>
</br>  
<div class="row">
	<div class="col-md-12">
    	<a href="#" style="color:blue;">Logout</a>
	</div>
</div> 