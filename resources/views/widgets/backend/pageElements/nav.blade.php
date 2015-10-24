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
						<a href="{{ route('backend.data.product.index') }}"><i class="fa fa-glass"></i> <span class="nav-label">Produk</span></a>
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
						<a href="{{ route('backend.data.customer.index') }}"><i class="fa fa-users"></i><span class="nav-label">Kostumer</span></a>
					</li>
					<li class="@if($subnav_active=='buy') active @endif">
					 	<a href="{{ route('backend.data.transaction.index', ['type' => 'buy']) }}"><i class="fa fa-inbox"></i><span class="nav-label">Pembelian</span></a>
					</li>
					<li class="@if($subnav_active=='sell') active @endif">
					 	<a href="{{ route('backend.data.transaction.index', ['type' => 'sell']) }}"><i class="fa fa-briefcase"></i><span class="nav-label">Penjualan</span></a>
					</li>
					<li class="@if($subnav_active=='payment') active @endif">
					 	<a href="{{ route('backend.data.payment.index') }}"><i class="fa fa-file-o"></i><span class="nav-label">Nota Bayar</span></a>
					</li>
				</ul>
			</li>
			<li class="@if($nav_active=='settings') active @endif">
				<a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Pengaturan</span></a>
				<ul class="nav nav-second-level">
					<li class="@if($subnav_active=='category') active @endif">
						<a href="{{ route('backend.settings.category.index') }}"><i class="fa fa-tags"></i> <span class="nav-label">Kategori</span></a>
					</li>
					<li class="@if($subnav_active=='courier') active @endif">
						<a href="{{ route('backend.settings.courier.index') }}"><i class="fa fa-truck"></i> <span class="nav-label">Kurir</span></a>
					</li>
					<li class="@if($subnav_active=='store') active @endif">
						<a href="{{ route('backend.settings.store.index') }}"><i class="fa fa-home"></i> <span class="nav-label">Toko Online</span></a>
					</li>
					<li>
						<a href=""><i class="fa fa-life-ring"></i> <span class="nav-label">Policy</span></a>
					</li>
					<li class="@if($subnav_active=='admin') active @endif">
						<a href=""><i class="fa fa-user"></i> <span class="nav-label">Admin</span></a>
					</li>
				</ul>
			</li>
			<li class="@if($nav_active=='storage') active @endif">
				<a href="#"><i class="fa fa-file-text-o"></i> <span class="nav-label">Laporan</span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href=""><i class="fa fa-briefcase"></i> <span class="nav-label">Transaksi</span></a>
						<ul class="nav nav-third-level">
							<li><a href="">Pesanan Belum Dibayar</a></li>
							<li><a href="">Pesanan Belum Dikirim</a></li>
							<li><a href="">Pesanan Belum Tiba</a></li>
						</ul>
					</li>
					<li class="@if($subnav_active=='topSellingProduct') active @endif">
						<a href="{{ route('backend.report.topSellingProduct') }}"><i class="fa fa-archive"></i> <span class="nav-label">Produk Terlaris</span></a>
					</li>					
					<li class="@if($subnav_active=='pointlog') active @endif">
						<a href="{{ route('backend.report.pointlog') }}"><i class="fa fa-briefcase"></i> <span class="nav-label">Transaksi Pointlog</span></a>
					</li>
					<li>
						<a href=""><i class="fa fa-line-chart"></i> <span class="nav-label">Perpindahan Stok</span></a>
					</li>
					<li class="@if($subnav_active=='criticalstock') active @endif">
						<a href="{{ route('backend.report.criticalstock') }}"><i class="fa fa-exclamation-circle"></i> <span class="nav-label">Stok Kritis</span></a>
					</li>
				</ul>
			</li>
		</ul>

	</div>
</nav>