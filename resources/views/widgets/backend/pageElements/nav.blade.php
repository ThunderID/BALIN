<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                {!! HTML::image('Balin/admin/image/logo.png') !!}
            </li>
            <li class="@if($nav_active=='dashboard') active @endif">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="@if($nav_active=='administrative') active @endif }}">
                <a href="#"><i class="fa fa-unlock-alt"></i> <span class="nav-label">Administrative</span></a>
                <ul class="nav nav-second-level">
                    <li><a href="#">Admin</a></li>
                    <li><a href="#">Data User</a></li>
                    <li><a href="#">Ganti Password User</a></li>
                    <li><a href="#">Blokir User</a></li>
                    <li><a href="#">Log User</a></li>
                    <li><a href="#">Log Aplikasi</a></li>
                </ul>
            </li>
            <li class="@if($nav_active=='customer') active @endif">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Customer</span></a>
            </li>
            <li class="@if($nav_active=='storage') active @endif">
                <a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Inventory</span></a>
            </li>
            <li class="@if($nav_active=='transaction') active @endif">
                <a href="#"><i class="fa fa-briefcase"></i> <span class="nav-label">Transaksi</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="#">Penjualan</a></li>
                    <li><a href="#">Kupon</a></li>
                </ul>
            </li>
            <li class="@if($nav_active=='payment') active @endif">
                <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Pembayaran</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="#">Validasi Pembayaran</a></li>
                    <li><a href="#">Data Pembayaran</a></li>
                </ul>
            </li>
            <li class="@if($nav_active=='shipping') active @endif">
                <a href="#"><i class="fa fa-truck"></i> <span class="nav-label">Pengiriman Barang</span>  <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="#">Kirim Barang</a></li>
                    <li><a href="#">Data Pengirimin</a></li>
                    <li><a href="#">Kurir</a></li>
                </ul>
            </li>
            <li class="@if($nav_active=='report') active @endif">
                <a href="#"><i class="fa fa-file"></i> <span class="nav-label">Laporan</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="#">Laporan Penjualan</a></li>
                    <li><a href="#">Laporan Kupon</a></li>
                    <li><a href="#">Laporan Stock</a></li>
                </ul>
            </li>
            <li class="@if($nav_active=='settings') active @endif">
                <a href="#"><i class="fa fa-globe"></i> <span class="nav-label">Settings</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="#">Homepage Config</a></li>
                </ul>
            </li>
            <li class="@if($nav_active=='dashboard') active @endif">
                <a href="{{ route('backend.supplier.index') }}"><i class="fa fa-university"></i> <span class="nav-label">Supplier</span></a>
            </li>
            <li class="@if($nav_active=='product') active @endif">
                <a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Product</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="@if(isset($subnav_active)&&($subnav_active=='category')) active @endif"><a href="{{ route('backend.category.index') }}">Category</a></li>
                    <li class="@if(isset($subnav_active)&&($subnav_active=='product')) active @endif"><a href="{{ route('backend.product.index') }}">Product</a></li>
                    <li><a href="{{ route('backend.price.index') }}">Price</a></li>
                    <li><a href="{{ route('backend.discount.index') }}">Discount</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>