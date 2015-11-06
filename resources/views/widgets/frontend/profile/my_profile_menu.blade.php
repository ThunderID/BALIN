<div class="row">
	<div class="col-md-12">
		<h3 class="caption-info m-t-xxs">Orders</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled menu-info">
			<li><a href="{{ URL::route('frontend.cart.index') }}">Shopping Cart</a></li>
			<li><a href="#">Procesed Order</a></li>
			<li><a href="#">View Order History</a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    	<h3 class="caption-info">Account</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled menu-info">
			<li><a href="{{ route('frontend.profile.index') }}">Profile Details</a></li>
			<li><a href="{{ route('frontend.profile.changeProfile') }}">Change Profile</a></li>
			<li><a href="{{ route('frontend.profile.changePassword') }}">Change Password</a></li>
		</ul>
	</div>
</div>  
<div class="row">
	<div class="col-md-12">
    	<h3 class="caption-info">Membership</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled menu-info">
			<li><a href="{{ route('frontend.profile.membershipDetail') }}">Membership Details</a></li>
			<li><a href="#">Coupon Transaction</a></li>
			<li><a href="#">Point History</a></li>
			<li><a href="#">Quota Invite</a></li>
			<li class="last-child"><a href="{{ route('frontend.dologout') }}">Logout</a></li>
		</ul>
	</div>
</div>