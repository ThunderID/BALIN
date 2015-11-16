<ol class="breadcrumb hollow m-t-md p-l-none" style="background:none">
	<li>
		<a class="hover-black" href="{{ route('frontend.home.index') }}">Home</a>
	</li>
	@foreach($breadcrumb as $b_title => $b_url)
		@if($b_url == end($breadcrumb))
			<li class="active">
				<a class="hover-gray" href="{{ $b_url }}"><strong>{{$b_title }}</strong></a>
			</li>
		@else
			<li>
				<a class="hover-black" href="{{ $b_url }}"> {{$b_title}} </a>
			</li>
		@endif
	@endforeach
</ol>