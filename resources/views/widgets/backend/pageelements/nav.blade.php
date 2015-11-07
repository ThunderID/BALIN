<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li class="nav-header">
				{!! HTML::image('Balin/admin/image/logo.png') !!}
			</li>
			<li class="@if($nav_active=='dashboard') active @endif">
				<a href="{{ route('backend.home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
			</li>
			<li class="@if($nav_active=='data') active @endif }}">
				<a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Data</span></a>
				<ul class="nav nav-second-level">
					<li class="@if($subnav_active=='products') active @endif">
						<a href="{{ route('backend.data.productuniversal.index') }}"><i class="fa fa-glass"></i> <span class="nav-label">Produk</span></a>
					</li>
					<li class="@if($subnav_active=='supplier') active @endif">
						<a href="{{ route('backend.data.supplier.index') }}"><i class="fa fa-suitcase"></i><span class="nav-label">Supplier</span></a>
					</li>
					<li class="@if($subnav_active=='customer') active @endif">
						<a href="{{ route('backend.data.customer.index') }}"><i class="fa fa-users"></i><span class="nav-label">Kostumer</span></a>
					</li>
					<li class="@if($subnav_active=='buy') active @endif">
					 	<a href="{{ route('backend.data.transaction.index', ['type' => 'buy']) }}"><i class="fa fa-arrow-circle-left"></i><span class="nav-label">Pembelian</span></a>
					</li>
					<li class="@if($subnav_active=='sell') active @endif">
					 	<a href="{{ route('backend.data.transaction.index', ['type' => 'sell']) }}"><i class="fa fa-arrow-circle-right"></i><span class="nav-label">Penjualan</span></a>
					</li>
					<li class="@if($subnav_active=='payment') active @endif">
					 	<a href="{{ route('backend.data.payment.index') }}"><i class="fa fa-credit-card"></i><span class="nav-label">Nota Bayar</span></a>
					</li>
					<li class="@if($subnav_active=='shipment') active @endif">
					 	<a href="{{ route('backend.data.shipment.index') }}"><i class="fa fa-paper-plane"></i><span class="nav-label">Resi Pengiriman</span></a>
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
					<li class="@if($subnav_active=='voucher') active @endif">
						<a href="{{ route('backend.settings.voucher.index') }}"><i class="fa fa-money"></i> <span class="nav-label">Voucher</span></a>
					</li>
					<li class="@if($subnav_active=='store') active @endif">
						<a href=""><i class="fa fa-home"></i> <span class="nav-label">Toko Online</span></a>
						<ul class="nav nav-third-level">
							<li><a href="{{ route('backend.settings.store.index') }}">Toko</a></li>
							<li><a href="{{ route('backend.settings.feature.index') }}">Etalase</a></li>
							<li><a href="{{ route('backend.settings.store.edit', 8) }}">Tentang Kami</a></li>
							<li><a href="{{ route('backend.settings.store.edit', 10) }}">Syarat & Ketentuan</a></li>
							<li><a href="{{ route('backend.settings.store.edit', 9) }}">Mengapa bergabung</a></li>
						</ul>
					</li>

					<li class="@if($subnav_active=='policy') active @endif">
						<a href="{{ route('backend.settings.policies.index') }}"><i class="fa fa-lock"></i> <span class="nav-label">Policy</span></a>
					</li>
					<li class="@if($subnav_active=='authentication') active @endif">
						<a href="{{ route('backend.settings.authentication.index') }}"><i class="fa fa-key"></i> <span class="nav-label">Otentikasi</span></a>
					</li>				
				</ul>
			</li>
			<li class="@if($nav_active=='storage') active @endif">
				<a href="#"><i class="fa fa-file-text-o"></i> <span class="nav-label">Laporan Gudang</span></a>
				<ul class="nav nav-second-level">
					<li class="@if($subnav_active=='critical') active @endif">
						<a href="{{ route('backend.report.critical.stock') }}"><i class="fa fa-exclamation-circle"></i> <span class="nav-label">Stok Kritis</span></a>
					</li>
				</ul>
			</li>
			<li class="@if($nav_active=='market') active @endif">
				<a href="#"><i class="fa fa-file-text-o"></i> <span class="nav-label">Laporan Pasar</span></a>
				<ul class="nav nav-second-level">
					<li class="@if($subnav_active=='downline') active @endif">
						<a href="{{ route('backend.report.customer.downline') }}"><i class="fa fa-archive"></i> <span class="nav-label">Kostumer Dengan Downline Terbanyak</span></a>
					</li>
					<li class="@if($subnav_active=='balance') active @endif">
						<a href="{{ route('backend.report.customer.balance') }}"><i class="fa fa-archive"></i> <span class="nav-label">Kostumer Dengan Point Terbanyak</span></a>
					</li>
					<li class="@if($subnav_active=='customermostbuy') active @endif">
						<a href="{{ route('backend.report.customer.mostbuy') }}"><i class="fa fa-archive"></i> <span class="nav-label">Kostumer Paling Banyak Belanja</span></a>
					</li>
					<li class="@if($subnav_active=='customerfrequentbuy') active @endif">
						<a href="{{ route('backend.report.customer.frequentbuy') }}"><i class="fa fa-archive"></i> <span class="nav-label">Kostumer Paling Sering Belanja</span></a>
					</li>
					<li class="@if($subnav_active=='productmostbuy') active @endif">
						<a href="{{ route('backend.report.product.mostbuy') }}"><i class="fa fa-archive"></i> <span class="nav-label">Produk Paling Banyak Dibeli</span></a>
					</li>
					<li class="@if($subnav_active=='productfrequentbuy') active @endif">
						<a href="{{ route('backend.report.product.frequentbuy') }}"><i class="fa fa-archive"></i> <span class="nav-label">Produk Paling Sering Dibeli</span></a>
					</li>
				</ul>
			</li>
			<li class="@if($nav_active=='finance') active @endif">
				<a href="#"><i class="fa fa-file-text-o"></i> <span class="nav-label">Laporan Keuangan</span></a>
				<ul class="nav nav-second-level">
					<li class="@if($subnav_active=='point') active @endif">
						<a href="{{ route('backend.report.finance.point') }}"><i class="fa fa-archive"></i> <span class="nav-label">Pemberian Point</span></a>
					</li>
					<li class="@if($subnav_active=='transaction') active @endif">
						<a href="{{ route('backend.report.finance.transaction') }}"><i class="fa fa-archive"></i> <span class="nav-label">Transaksi Jual / Beli</span></a>
					</li>
					<li class="@if($subnav_active=='price') active @endif">
						<a href="{{ route('backend.report.finance.price') }}"><i class="fa fa-archive"></i> <span class="nav-label">Perbandingan HPP dan HJ</span></a>
					</li>
				</ul>
			</li>
			<li class="@if($nav_active=='audit') active @endif">
				<a href="#"><i class="fa fa-file-text-o"></i> <span class="nav-label">Laporan Audit</span></a>
				<ul class="nav nav-second-level">
					<li class="@if($subnav_active=='abandoned') active @endif">
						<a href="{{ route('backend.report.audit.abandoned') }}"><i class="fa fa-archive"></i> <span class="nav-label">Abandoned Cart</span></a>
					</li>
					<li class="@if($subnav_active=='paid') active @endif">
						<a href="{{ route('backend.report.audit.paid') }}"><i class="fa fa-archive"></i> <span class="nav-label">Penanganan Pembayaran Transaksi</span></a>
					</li>
					<li class="@if($subnav_active=='ship') active @endif">
						<a href="{{ route('backend.report.audit.ship') }}"><i class="fa fa-archive"></i> <span class="nav-label">Penanganan Pengiriman Transaksi</span></a>
					</li>
					<li class="@if($subnav_active=='deliver') active @endif">
						<a href="{{ route('backend.report.audit.deliver') }}"><i class="fa fa-archive"></i> <span class="nav-label">Penanganan Transaksi Lengkap</span></a>
					</li>
					<li class="@if($subnav_active=='cancel') active @endif">
						<a href="{{ route('backend.report.audit.cancel') }}"><i class="fa fa-archive"></i> <span class="nav-label">Pembatalan Transaksi</span></a>
					</li>
					<li class="@if($subnav_active=='price') active @endif">
						<a href="{{ route('backend.report.audit.price') }}"><i class="fa fa-archive"></i> <span class="nav-label">Perubahan Harga Produk</span></a>
					</li>
					<li class="@if($subnav_active=='voucher') active @endif">
						<a href="{{ route('backend.report.audit.voucher') }}"><i class="fa fa-archive"></i> <span class="nav-label">Penambahan Voucher</span></a>
					</li>
					<li class="@if($subnav_active=='policy') active @endif">
						<a href="{{ route('backend.report.audit.policy') }}"><i class="fa fa-archive"></i> <span class="nav-label">Perubahan Policy (Business)</span></a>
					</li>
					<li class="@if($subnav_active=='point') active @endif">
						<a href="{{ route('backend.report.audit.point') }}"><i class="fa fa-archive"></i> <span class="nav-label">Penambahan Point Manual</span></a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>