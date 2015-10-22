<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li class="nav-header">
				{!! HTML::image('Balin/admin/image/logo.png') !!}
			</li>
			<li class="@if($nav_active=='dashboard') active @endif">
				<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
			</li>
			<li class="@if($nav_active=='data') active @endif }}">
				<a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Data</span></a>
				<ul class="nav nav-second-level">
					<li class="@if($subnav_active=='products') active @endif">
						<a href="{{ route('backend.data.product.index') }}"><i class="fa fa-glass"></i> <span class="nav-label">Product</span></a>
						{{-- <ul class="nav nav-third-level">
							<li><a href="#">Stock</a></li>
							<li><a href="{{ route('backend.price.index') }}">Price</a></li>
							<li><a href="{{ route('backend.data.product.index') }}">Products</a></li>
						</ul> --}}
					</li>
					<li class="@if($subnav_active=='supplier') active @endif">
						<a href="{{ route('backend.data.supplier.index') }}"><i class="fa fa-university"></i><span class="nav-label">Supplier</span></a>
					</li>
					<li class="@if($subnav_active=='customer') active @endif">
						<a href="#"><i class="fa fa-users"></i><span class="nav-label">Customer</span></a>
						<ul class="nav nav-third-level">
							<li><a href="{{ route('backend.data.customer.index') }}">Customer</a></li>
							<li><a href="#">Point Logs</a></li>
						</ul>
					</li>
					 <li class="@if($subnav_active=='transaction') active @endif">
					 	<a href="#"><i class="fa fa-briefcase"></i><span class="nav-label">Transactions</span></a>
					 	<ul class="nav nav-third-level">
					 		<li class="@if(isset($sub_subnav_active)&&($sub_subnav_active=='buy')) active @else @endif">
					 			<a href="{{ route('backend.data.transaction.index', ['type' => 'buy']) }}">Order</a>
					 		</li>
					 		<li class="@if(isset($sub_subnav_active)&&($sub_subnav_active=='sell')) active @else @endif">
					 			<a href="{{ route('backend.data.transaction.index', ['type' => 'sell']) }}">Sales</a>
					 		</li>
					 	</ul>
					 </li>
				</ul>
			</li>
			<li class="@if($nav_active=='settings') active @endif">
				<a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Settings</span></a>
				<ul class="nav nav-second-level">
					<li class="@if($subnav_active=='category') active @endif">
						<a href="{{ route('backend.settings.category.index') }}"><i class="fa fa-tags"></i> <span class="nav-label">Categories</span></a>
					</li>
					<li>
						<a href=""><i class="fa fa-credit-card"></i> <span class="nav-label">Payment Methods</span></a>
					</li>
					<li class="@if($subnav_active=='courier') active @endif">
						<a href="{{ route('backend.settings.courier.index') }}"><i class="fa fa-truck"></i> <span class="nav-label">Couriers</span></a>
					</li>
					<li class="@if($subnav_active=='store') active @endif">
						<a href="{{ route('backend.settings.store.index') }}"><i class="fa fa-home"></i> <span class="nav-label">Store</span></a>
					</li>
					<li>
						<a href=""><i class="fa fa-life-ring"></i> <span class="nav-label">Policies</span></a>
					</li>
				</ul>
			</li>
			<li class="@if($nav_active=='storage') active @endif">
				<a href="#"><i class="fa fa-file-text-o"></i> <span class="nav-label">Report</span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href=""><i class="fa fa-briefcase"></i> <span class="nav-label">Transactions</span></a>
						<ul class="nav nav-third-level">
							<li><a href="">New Orders</a></li>
							<li><a href="">Awaiting Payments</a></li>
							<li><a href="">Awaiting Shipping</a></li>
							<li><a href="">Complete Orders (Delivered)</a></li>
							<li><a href="">Purchasing Stocks</a></li>
						</ul>
					</li>
					<li>
						<a href=""><i class="fa fa-line-chart"></i> <span class="nav-label">Stocks Movement</span></a>
					</li>
					 <li>
						<a href=""><i class="fa fa-exclamation-circle"></i> <span class="nav-label">Critical Stocks</span></a>
					</li>
				</ul>
			</li>
		</ul>

	</div>
</nav>