<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
		<!-- <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
			<div class="form-group">
				<input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
			</div>
		</form> -->
	</div>
	<div class="container-fluid">
		<ul class="nav navbar-top-links navbar-right">
			{{-- <li class="dropdown">
				<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
					<i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
				</a> --}}
				{{-- <ul class="dropdown-menu dropdown-alerts">
					<li>
						<a href="mailbox.html">
							<div>
								<i class="fa fa-envelope fa-fw"></i> You have 16 messages
								<span class="pull-right text-muted small">4 minutes ago</span>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="profile.html">
							<div>
								<i class="fa fa-twitter fa-fw"></i> 3 New Followers
								<span class="pull-right text-muted small">12 minutes ago</span>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="grid_options.html">
							<div>
								<i class="fa fa-upload fa-fw"></i> Server Rebooted
								<span class="pull-right text-muted small">4 minutes ago</span>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<div class="text-center link-block">
							<a href="notifications.html">
								<strong>See All Alerts</strong>
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
					</li>
				</ul> --}}
			{{-- </li> --}}
			<li class="dropdown userme">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
					<i class="fa fa-user"></i> {{ Auth::User()->name }}
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="{{ route('backend.changePassword') }}">Ganti Password</a></li>
					<li><a href="{{ route('backend.dologout') }}">Log Out</a></li>
				</ul>
			</li>
		</ul>
	</nav>
</nav>