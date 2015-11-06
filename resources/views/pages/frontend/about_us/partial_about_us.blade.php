@inject('about_us', 'App\Models\StoreSetting')
<?php
	$about_us = $about_us::where('type', 'about_us')->first();
?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			{!! $about_us['value'] !!}
		</div>
	</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>