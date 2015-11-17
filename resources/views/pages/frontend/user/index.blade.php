@extends('template.frontend.layout_account')

@section('right_content')
	<div class="row">
		<div class="col-sm-12">
			<h3 class="m-t-0">{{$title}}</h3>
			<p class="m-t-md"><strong>Halo, @if(Auth::user()->gender=='female')Ms. @else Mr. @endif {{Auth::user()->name}}!</strong></p>
			<p class="m-t-md">
			Melalui dashboard anda, anda dapat melihat aktivitas akun anda dan mengubah informasi akun. Klik link yang tersedia untuk melihat atau mengubah profil anda.
			</p>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<div class="row">
		<div class="col-sm-12">
			<h4>Informasi Akun</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<h5><strong>Informasi Umum <small><a class="link-grey hover-black unstyle" href="{{route('frontend.profile.edit')}}" class="balin-link">Ubah</a></small></strong></h5>
			<p>
				@if(Auth::user()->gender=='female')Ms. @else Mr. @endif {{Auth::user()->name}}<br/>
				{{Auth::user()->email}}<br/>
				@date_indo(Auth::user()->date_of_birth)<br/>
				<small><a class="link-grey hover-black unstyle" href="{{route('frontend.profile.edit')}}" class="balin-link text-right">Ubah Password</a></small><br/>
			</p>
		</div>
		<div class="col-sm-6">
			<h5><strong>Keanggotaan</strong></h5>
			<p>
				Referral Code <strong> {{Auth::user()->referral_code}} </strong>
				<br>
				Balance <strong> @money_indo(Auth::user()->balance) </strong>
				<br>
				Quota <strong>{{Auth::user()->quota}} </strong>
				<br>
				Downline <strong>{{Auth::user()->downline}} </strong> <small><a class="link-grey hover-black unstyle" href="{{route('frontend.profile.downline')}}">Daftar</a></small>
				@if(!is_null(Auth::user()->reference))
				<br>
				Referensi dari <strong>{{Auth::user()->reference}} </strong>
				@endif
			</p>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>

	<div class="row">
		<div class="col-sm-12">
			<h4>Alamat <small><small><a class="link-grey hover-black unstyle" href="{{route('frontend.profile.address.index')}}" class="balin-link">Ubah</a></small></small></h4>
			<p>
				{{Auth::user()->phone}}<br/>
				{{Auth::user()->address}}
				{{Auth::user()->zipcode}}<br/>
				<!-- <a class="link-grey hover-black unstyle" href="" class="balin-link text-right">Atur Buku Alamat</a><br/> -->
			</p>
		</div>
	</div>
@stop