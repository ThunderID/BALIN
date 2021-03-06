<div class="row">
	<div class="col-sm-12">
		<h3 class="page-title m-t-lg">{{$title}}</h3>
		<p class="m-t-md"><strong>Halo, @if(Auth::user()->gender=='female')Ms. @else Mr. @endif {{Auth::user()->name}}!</strong></p>
		<p class="m-t-md">
		Melalui dashboard anda, anda dapat melihat aktivitas akun anda dan mengubah informasi akun. Klik link yang tersedia untuk melihat atau mengubah profil anda.
		</p>
	</div>
</div>

<div class="clearfix">&nbsp;</div>

<div class="row">
	<div class="col-sm-12">
		<h4>Informasi Akun <small><a href="{{route('frontend.profile.edit')}}" class="balin-link">edit</a></small></h4>
		<p>
			@if(Auth::user()->gender=='female')Ms. @else Mr. @endif {{Auth::user()->name}}<br/>
			{{Auth::user()->email}}<br/>
			@date_indo(Auth::user()->date_of_birth)<br/>
			<a href="" class="balin-link text-right">Ubah Password</a><br/>
		</p>
	</div>
</div>

<div class="clearfix">&nbsp;</div>

<div class="row">
	<div class="col-sm-12">
		<h4>Alamat <small><a href="" class="balin-link">edit</a></small></h4>
		<p>
			{{Auth::user()->phone}}<br/>
			{{Auth::user()->address}}
			{{Auth::user()->zipcode}}<br/>
			<a href="" class="balin-link text-right">Atur Buku Alamat</a><br/>
		</p>
	</div>
</div>
