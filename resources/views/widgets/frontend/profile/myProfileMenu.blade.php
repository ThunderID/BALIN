<div class="row">
	<div class="col-md-12">
		<h3>Orders</h3>
	</div>
</div>


@include('widgets.particle.linkLabelBlue', array('linkText' => 'Shopping Chart', 'linkDirection' => '#'))

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Processed Order', 'linkDirection' => '#'))

@include('widgets.particle.linkLabelBlue', array('linkText' => 'View Order History', 'linkDirection' => '#'))
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

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Membership Details', 'linkDirection' => route('frontend.profile.membershipDetail')  ))

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Coupon Transactions', 'linkDirection' => '#'  ))

</br>  

@include('widgets.particle.linkLabelBlue', array('linkText' => 'Logout', 'linkDirection' => '#'  ))



