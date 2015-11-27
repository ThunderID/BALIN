@if(isset($searchResult))
</br>
<div class="row">
	<div class="col-md-12">
		@if(!is_array($searchResult))
			Menampilkan "{{$searchResult}}" (<a href="{{ $closeSearchLink }}" class="link-grey hover-black unstyle">hapus</a>)
		@else
			@if(count($searchResult) != 0)
				Menampilkan 
				@foreach($searchResult as $key => $sr)
					"{{$sr}}" (<a href="{{  route('frontend.product.index', $links[$key]) }}" class="link-grey hover-black unstyle">hapus</a>)
					@if(end($searchResult) != $sr)
						,
					@endif
				@endforeach
			@endif
		@endif
	</div>
</div>
@endif