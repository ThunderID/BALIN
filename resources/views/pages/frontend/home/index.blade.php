@inject('store', 'App\Models\StoreSetting')

<?php 
	$stores				= $store->type('slider')->ondate('now')->orderby('started_at', 'desc')->take(3)->get();
?>
@extends('template.frontend.layout')

@section('content')
	<!-- Full Page Image Background Carousel Header -->
	
	<div class="tp-banner-container">
		<div class="tp-banner" >
			<ul>
				<!-- SLIDE 1-->
				@foreach($stores as $key => $value)
				<li data-transition="fade" data-slotamount="5" data-masterspeed="700" >
					<!-- MAIN IMAGE -->
					@if(isset($value['images'][0]))
					<img src="{!!$value['images'][0]['image_lg']!!}"   alt="slidebg1"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
					@endif
					<?php $content 		= json_decode($value->value, true); ?>

					<?php $i = 0; ?>
					@foreach ($content as $k => $v)
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
								style="z-index: 6">@if(isset($v['slider_button_url'])) <a href="{!!$v['slider_button_url']!!}" class="btn-hollow hollow-black hollow-black-border"> {!! $v['slider_'. $k] !!} </a> @else {!! $v['slider_'. $k] !!} @endif
							</div>
						@endif
						<?php $i++; ?>
					@endforeach
				</li>
				@endforeach
			</ul>
		</div>
	</div>
@stop

@section('script')
	$('.btn-signup').click( function() {
		$('.sign-up').show();
		$('.sign-in').hide();
		$('.forgot').hide();
	});
	$('.btn-cancel').click( function() {
		$('.sign-up').hide();
		$('.forgot').hide();
		$('.sign-in').show();
	});
	$('.btn-forgot').click( function() {
		$('.sign-up').hide();
		$('.sign-in').hide();
		$('.forgot').show();
	});
@stop

@section('script_plugin')
	@include('plugins.revolution-slider')
@stop