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
   {!! HTML::style('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700') !!}
   <link rel="stylesheet" href="{{ elixir('Balin/web/css/style-web.css') }}">

</head>

<body>
	<div class="tp-banner-container hidden-xs">
		<div class="tp-banner" >
			<ul>
				<!-- SLIDE 1-->
				<li data-transition="fade" data-slotamount="5" data-masterspeed="700" 
					@if (($value['title']['title_active']=='0') && ($value['content']['content_active']=='0') && ($value['button']['button_active']=='0')) 
						data-link="{!!$value['button']['slider_button_url']!!}"
					@endif >
					<!-- MAIN IMAGE -->
					<img src="{!!$images['image_lg']!!}"   alt="slidebg1"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
					<?php $i = 0; ?>
					@foreach ($value as $k => $v)
						@if ($v[$k.'_active']=='1')
							<?php 
								$loc = explode('-', $v['slider_'. $k .'_location']); 
								$loc_x = strtolower($loc[1]);
								$loc_y = strtolower($loc[0]);
							?>
							<!-- LAYER NR. 1 -->
							<div class="tp-caption @if($k=='title') large_text @elseif($k=='content') medium_text @endif @if($loc_x=='left') skewfromleft @else skewfromright @endif"
								data-x="{{$loc_x}}"
								data-y="@if($loc_y=='top'){{'120'}}@elseif($loc_y=='bottom'){{'320'}}@else{{$loc_y}}@endif"
								data-speed="800"
								data-start="{{ ($i*800)+800 }}"
								data-easing="Power4.easeinOut"
								data-hoffset="@if($loc_x=='left'){{'100'}}@else{{'-100'}}@endif"
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="off"
								style="z-index: 6">
								@if (($k == 'button')&&($v['button_active']=='1'))
									<a href="{!!$v['slider_button_url']!!}" class="btn-hollow hollow-black hollow-black-border @if($loc_x=='left') m-l-xs @else m-r-xs @endif"> 
										{!! $v['slider_'. $k] !!} 
									</a> 
								@else 
									@if ($value['button']['button_active']=='0')
										<a href="{!!$value['button']['slider_button_url']!!}" class="link-white">{!! $v['slider_'. $k] !!}</a>
									@else
										{!! $v['slider_'. $k] !!}
									@endif
								@endif
							</div>
						@endif
						<?php $i++; ?>
					@endforeach
				</li>
			</ul>
		</div>
	</div>

	<section class="container-fluid hidden-sm hidden-md hidden-lg m-t-55">
		<div class="row">
			<?php $i = 0; ?>
			<div class="col-xs-12 p-l-none p-r-none m-t-lg" style="position:relative">
				<div class="caption-mobile">
					@if (($value['title']['title_active']!='0') && ($value['content']['content_active']!='0') && ($value['button']['button_active']!='0'))
						@foreach ($value as $k => $v)
							@if ($v[$k.'_active']=='1')
								<?php 
									$loc = explode('-', $v['slider_'. $k .'_location']); 
									$loc_x = strtolower($loc[1]);
									$loc_y = strtolower($loc[0]);
								?>
								<div class="@if($loc_x=='left') left @else right @endif">
									@if ($k=='title')
										<h3><a href="{!!$value['button']['slider_button_url']!!}" class="link-white unstyle">{!! $v['slider_'. $k] !!}</a></h3>
									@endif

									@if (isset($v['slider_button_url'])) 
										<?php $action=$v['slider_button_url']; ?>
									@endif
								</div>

							@endif
						@endforeach
					@else
						<?php $action=$value['button']['slider_button_url']; ?>
					@endif
				</div>
				<a href="{{ $action }}">
					@if(isset($value['images'][0]))
						<img src="{!!$value['images'][0]['image_lg']!!}" style="" class="img-responsive">
					@endif
				</a>
			</div>
		</div>
	</section>
	<!-- /#wrapper -->
	<!-- jQuery -->
	{!! HTML::script('/Balin/admin/js/jquery.js') !!}
	{!! HTML::script('/Balin/admin/js/bootstrap.min.js') !!}
	
	<!-- jQuery -->
	@include('plugins.revolution-slider')
</body>
</html>