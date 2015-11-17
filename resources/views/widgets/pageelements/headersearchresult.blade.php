@if(isset($searchResult))
</br>
<div class="row">
	<div class="col-md-12">
		Menampilkan data pencarian "{{$searchResult}}" (<a href="{{ $closeSearchLink }}" class="link-grey hover-black unstyle">hapus</a>)
	</div>
</div>
@endif