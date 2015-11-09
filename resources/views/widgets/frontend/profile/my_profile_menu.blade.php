<div class="row">
	<div class="col-sm-12">
		<h3 class="page-title m-t-lg">Akun Saya</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled menu-info">
			<li class="m-t-sm"><a href="{{route('frontend.profile.index')}}" class="@if($subnav_active=='account_index') active @endif">Dashboard Saya</a></li>
			<li class="m-t-sm"><a href="{{route('frontend.profile.edit')}}" class="@if($subnav_active=='account_setting') active @endif">Pengaturan Akun</a></li>
			<li class="m-t-sm"><a href="{{route('frontend.profile.address.index')}}" class="@if($subnav_active=='account_address') active @endif">Buku Alamat</a></li>
			<li class="m-t-sm"><a href="#" class="@if($subnav_active=='account_order') active @endif">Riwayat Pesanan</a></li>
			<li class="m-t-sm"><a href="{{route('frontend.profile.point')}}" class="@if($subnav_active=='account_point') active @endif">Buku Tabungan</a></li>
			<!-- <li class="m-t-sm"><a href="{{route('frontend.profile.downline')}}" class="@if($subnav_active=='account_downline') active @endif">Daftar Downline</a></li> -->
			@if(!Auth::user()->is_active)
				<li class="m-t-sm"><a href="#" class="@if($subnav_active=='account_reference') active @endif">Referensi</a></li>
			@endif
			<li class="m-t-sm"><a href="#">Logout</a></li>
		</ul>
	</div>
</div>