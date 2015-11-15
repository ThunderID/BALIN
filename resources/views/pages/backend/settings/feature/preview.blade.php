<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Preview - Balin</title>

	<!-- Custom CSS -->
   {!! HTML::style('Balin/admin/css/bootstrap.min.css') !!}
   {!! HTML::style('Balin/admin/css/font-awesome.min.css') !!}

</head>

<body>
	<div class="tp-banner-container">
		<div class="tp-banner" >
			<ul>
				<!-- SLIDE 1-->
				<li data-transition="fade" data-slotamount="5" data-masterspeed="700" >
					<!-- MAIN IMAGE -->
					<img src="/Balin/web/image/slide-2-large.png"   alt="slidebg1"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">

					<?php $i = 0; ?>
					@foreach ($value as $k => $v)
						@if ($v[$k.'_active']=='1')
							<?php 
								$loc = explode('-', $v['slider_'. $k .'_location']); 
							?>
							<!-- LAYER NR. 1 -->
							<div class="tp-caption medium_bg_asbestos-{{$k}} skewfromright"
								data-x="{{ strtolower($loc[1]) }}"
								data-y="{{ strtolower($loc[0]) }}"
								data-speed="800"
								data-start="{{ ($i*800)+800 }}"
								data-easing="Power4.easeinOut"
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="off"
								style="z-index: 6">{!! $v['slider_'. $k] !!}
							</div>
						@endif
						<?php $i++; ?>
					@endforeach
				</li>
			</ul>
		</div>
	</div>
	<!-- /#wrapper -->
	<!-- jQuery -->
	{!! HTML::script('/Balin/admin/js/jquery.js') !!}
	{!! HTML::script('/Balin/admin/js/bootstrap.min.js') !!}
	
	<!-- jQuery -->
	@include('plugins.revolution-slider')
</body>
</html>