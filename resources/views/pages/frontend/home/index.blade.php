@inject('store', 'App\Models\StoreSetting')

<?php 
	$stores				= $store->type('slider')->onactive('now')->with('images')->orderby('started_at', 'desc')->get();
?>
@extends('template.frontend.layout')

@section('content')
	<!-- Full Page Image Background Carousel Header -->
	
	<div class="tp-banner-container hidden-xs hidden-sm " style='margin-top:50px'>
		<div class="tp-banner" >
			<ul>
				<!-- SLIDE 1-->
				@forelse($stores as $key => $value)
					<?php $content 		= json_decode($value->value, true);?>

					<li data-transition="fade" data-slotamount="5" data-masterspeed="700" 
						@if (($content['title']['title_active']=='0') && ($content['content']['content_active']=='0') && ($content['button']['button_active']=='0')) 
							data-link="{!!$content['button']['slider_button_url']!!}"
						@endif>

						<!-- MAIN IMAGE -->
						@if(isset($value['images'][0]))
							<img src="{!!$value['images'][0]['image_lg']!!}"   alt="slidebg1"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
						@endif

						<?php $i = 0; ?>
						@foreach ($content as $k => $v)
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
										@if ($content['button']['button_active']=='0')
											<a href="{!!$content['button']['slider_button_url']!!}" class="link-white">{!! $v['slider_'. $k] !!}</a>
										@else
											{!! $v['slider_'. $k] !!}
										@endif
									@endif
								</div>
							@else
								<div class="tp-caption medium_text skewfromright"
									data-x="0"
									data-y="0"
									data-speed="800"
									data-start="0"
									data-easing="Power4.easeinOut"
									data-hoffset="0"
									data-endspeed="300"
									data-endeasing="Power1.easeIn"
									data-captionhidden="off"
									style="z-index: 6">&nbsp;
								</div>
							@endif
							<?php $i++; ?>
						@endforeach
					</li>
				@empty
				@endforelse
			</ul>
		</div>
	</div>
	<section class="container-fluid hidden-md hidden-lg m-t-55">
		<div class="row">
			@forelse($stores as $key => $value)
				<?php $content 		= json_decode($value->value, true); $action=''; ?>

				<?php $i = 0; ?>
				<div class="col-xs-12 p-l-none p-r-none border-bottom" style="position:relative;">
					<div class="caption-mobile">
						@if (($content['title']['title_active']!='0') && ($content['content']['content_active']!='0') && ($content['button']['button_active']!='0'))
							@foreach ($content as $k => $v)
								@if ($v[$k.'_active']=='1')
									<?php 
										$loc = explode('-', $v['slider_'. $k .'_location']); 
										$loc_x = strtolower($loc[1]);
										$loc_y = strtolower($loc[0]);
									?>
									<div class="@if($loc_x=='left') left @else right @endif">
										@if ($k=='title')
											<h3><a href="{!!$content['button']['slider_button_url']!!}" class="link-white unstyle">{!! $v['slider_'. $k] !!}</a></h3>
										@endif

										@if (isset($v['slider_button_url'])) 
											<?php $action=$v['slider_button_url']; ?>
										@endif
									</div>

								@endif
							@endforeach
						@else
							<?php $action=$content['button']['slider_button_url']; ?>
						@endif
					</div>
					<a href="{{ $action }}">
						@if(isset($value['images'][0]))
							<img src="{!!$value['images'][0]['image_lg']!!}" class="img-responsive" style="width:100%;">
						@endif
					</a>
				</div>
			@empty
			@endforelse
		</div>
		<div class="row">
			<div class="hidden-lg hidden-md hidden-sm col-xs-12">
				<div class="row clearfix" style="margin-top:76px;">
				</div>
			</div>
		</div>			
	</section>
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