@inject('datas', 'App\Models\Product')
@inject('category', 'App\Models\Category')
@inject('tagged', 'App\Models\tag')
<?php 
	$perpage 			= 12;

	$datas 				= $datas->currentprice(true)->DefaultImage(true)->sellable(true);

	if($filters->count())
	{
		foreach ($filters as $filter) 
		{
			if(str_is('tagging.*', $filter['key']))
			{
				$datas 	= call_user_func([$datas, 'tagging'], $filter['value']);
			}
			elseif(str_is('category', $filter['key']))
			{
				$datas 	= call_user_func([$datas, 'categoriesslug'], $filter['value']);
			}
			else
			{
				$datas 	= call_user_func([$datas, $filter['key']], $filter['value']);
			}
		}
	}


	$paginator 		= new PrettyPaginate($datas->count() , (int)$page, $perpage, $datas->count());


	$datas 			= $datas->with('lables')->take($perpage)->skip(($page-1) * $perpage);

	if(!$filters->has('sort'))
	{
		$datas 		= $datas->orderby('products.created_at','desc')->get();
	}
	else
	{
		$datas 		= $datas->get();
	}

	$category      	= $category::where('category_id', 0)->orderby('name', 'asc')
								->get();

	$tag_types      		= $tagged::where('category_id', 0)->orderby('name', 'asc')
								->get();
	// get current tag
	$current_tag = [];
	foreach ($tag_types as $tag_type)
	{
		if (Input::has($tag_type->slug))
		{
			$current_tag[$tag_type->slug] = Input::get($tag_type->slug);
		}
	}
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container m-t-sm">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				@include('widgets.breadcrumb')
			</div>
		</div>

		<div class="row">
			<div class="container">
				<div class="col-md-12 col-sm12 hidden-xs">
					<div class="row ribbon">
						<div class="col-md-9 col-sm-9 p-l-xxs">
							<ul class="list-inline ribbon-menu ribbon-desktop m-b-none">
								<li>
							        <a role="button" id="collapse1" class="menu-accordion"  data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
										KATEGORI <i class="fa fa-chevron-circle-down pull-right"></i>
							        </a>									
								</li>						
								<li>
							        <a role="button" id="collapse2" class="menu-accordion"  data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										FILTER <i class="fa fa-chevron-circle-down pull-right"></i>
									</a>
								</li>
								<?php
								// <li>
								//  	<a role="button" id="collapse3" class="menu-accordion"  data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								// 		FILTER <i class="fa fa-chevron-circle-down pull-right"></i>
								// 	</a>
								// </li>
								?>
								<li>
							        <a role="button" id="collapse4" class="menu-accordion"  data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
										URUTKAN <i class="fa fa-chevron-circle-down pull-right"></i>
									</a>
								</li>
							</ul>
						</div>
						<div class="col-md-3 col-sm-3 p-l-xxs text-right">
							<div class="row f-searching">
								{!! Form::open(array('url' => route('frontend.product.index', Input::all()), 'method' => 'get', 'id' => 'form1', 'class' => 'form-group' )) !!}
									<div class="col-xs-10 col-sm-9 p-r-none p-l-none">
										{!! Form::text('name', null, ['class' => 'form-control hollow search inp-search', 'id' => 'input-search','placeholder' => 'Cari nama produk', 'required' => 'required'] ) !!}
									</div>
									<div class="col-xs-2 col-sm-3 p-l-none p-r-none p-b-xxs bt">
										<button type="submit"  class="btn-hollow btn-block btn-search t-sm" tabindex="21"><i class="fa fa-search" style="padding-top:3px;"></i></button>
									</div>
								{!! Form::close() !!}
					      	</div>
						</div>																								
					</div>

					<div class="row collapse collapse-category" id="collapseOne" data-collapse="collapse1" aria-expanded="true">
						<div class="col-md-12 p-l-xxs ribbon-submenu">
							<div class="row p-sm">
								<ul class="list-inline m-b-none">
								@foreach ($category as $cat)
									<div class="col-md-3 col-sm-4">
										<li><a @if(Input::has('category') && Input::get('category')==$cat['slug']) class="active" @endif href="{{ route('frontend.product.index', array_merge(Input::all(), ['page' => $page,'category' => $cat['slug']])) }}">{{ $cat->name }}</a></li>
									</div>
								@endforeach	
								</ul>					
							</div>
						</div>						
					</div>

					<div class="row collapse collapse-category" id="collapseTwo" data-collapse="collapse2" aria-expanded="true">
						<div class="col-md-12 p-l-xxs ribbon-submenu">
							<div class="row p-sm">
								<ul class="list-inline m-b-none">
									@foreach ($tag_types as $tag_type)
										@if($tag_type->is_root)
											<div class="col-md-12 col-sm-12 text-white">
												<p class="ribbon-title">{{ strtoupper($tag_type->name) }}</p>
											</div>
											{{-- LIST OF TAGS --}}
											@foreach ($all_tags as $tag)
												@if ($tag_type->id == $tag->category_id)
													<div class="col-md-3 col-sm-4">
														<li><a class='{{ $filters->where("value", $tag->slug)->count() ? "active": ""}}' href='{{ route("frontend.product.index", ["page" => $page] + array_except($current_tag, [$tag_type->slug]) + [$tag_type->slug => $tag->slug]) }}' class=''>{{ $tag->name }}</a></li>
													</div>
												@endif
											@endforeach

								      	@endif
									@endforeach											
								</ul>					
							</div>						
						</div>						
					</div>

					<div class="row collapse collapse-category" id="collapseFour" data-collapse="collapse4" aria-expanded="true">
						<div class="col-md-12 p-l-xxs ribbon-submenu">
							<div class="row p-sm">
								<ul class="list-inline m-b-none">
									<div class="col-md-3 col-sm-4">
										<li><a @if(Input::get('sort')=='name-asc') class="active" @endif href="{{ route('frontend.product.index', array_merge(Input::all(), ['page' => $page, 'sort' => 'name-asc'])) }}">Nama Produk A-Z</a></li>
									</div>
									<div class="col-md-3 col-sm-4">
										<li><a @if(Input::get('sort')=='name-desc') class="active" @endif href="{{ route('frontend.product.index', array_merge(Input::all(), ['page' => $page, 'sort' => 'name-desc'])) }}">Nama Produk Z-A</a></li>
									</div>

									<div class="col-md-3 col-sm-4">
										<li><a @if(Input::get('sort')=='price-asc') class="active" @endif href="{{ route('frontend.product.index', array_merge(Input::all(), ['page' => $page, 'sort' => 'price-asc'])) }}">Harga Produk Termurah</a></li>
									</div>
									<div class="col-md-3 col-sm-4">
										<li><a @if(Input::get('sort')=='price-desc') class="active" @endif href="{{ route('frontend.product.index', array_merge(Input::all(), ['page' => $page, 'sort' => 'price-desc'])) }}">Harga Produk Termahal</a></li>
									</div>

									<div class="col-md-3 col-sm-4">
										<li><a @if(Input::get('sort')=='date-desc') class="active" @endif href="{{ route('frontend.product.index', array_merge(Input::all(), ['page' => $page, 'sort' => 'date-desc'])) }}">Produk Terbaru</a></li>
									</div>
									<div class="col-md-3 col-sm-4">
										<li><a @if(Input::get('sort')=='date-asc') class="active" @endif href="{{ route('frontend.product.index', array_merge(Input::all(), ['page' => $page, 'sort' => 'date-asc'])) }}">Produk Terlama</a></li>
									</div>																			
								</ul>					
							</div>						
						</div>						
					</div>					

				</div>
			</div>
		</div>

		<div class="row  ribbon-mobile">
			<div class="hidden-lg hidden-md hidden-sm col-xs-12">
				<div class="col-xs-12 p-l-none p-r-none">
					<ul class="list-unstyled ribbon-menu m-b-none ribbon">
						<li>
							<a href="#" data-toggle="modal" data-target="#modalCategory">									
							KATEGORI <i class="fa fa-chevron-circle-right pull-right"></i>
							</a>						    
						</li>
						<li>
							<a href="#" data-toggle="modal" data-target="#modalTag">									
							FILTER <i class="fa fa-chevron-circle-right pull-right"></i>
							</a>
						</li>
						<?php
						// <li>
						// 	<a href="#" data-toggle="modal" data-target="#modalFilter">									
						// 	FILTER <i class="fa fa-chevron-circle-right pull-right"></i>
						// 	</a>
						// </li>
						?>
						<li>
							<a href="#" data-toggle="modal" data-target="#modalSort">									
							URUTKAN <i class="fa fa-chevron-circle-right pull-right"></i>
							</a>
						</li>
						<li>
							<a href="#" data-toggle="modal" data-target="#modalSearch">									
							CARI <i class="fa fa-search pull-right"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div id="modalCategory" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header modal-filter-title">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				       		<h4 class="modal-title" id="exampleModalLabel">Pilih Kategori</h4>
				      	</div>
				      	<div class="modal-body ribbon-menu ribbon-menu-mobile">
							<ul class="list-inline m-b-none">
								@foreach ($category as $cat)
									<div class="col-xs-12">
										<li><a @if(Input::has('category') && Input::get('category')==$cat['slug']) class="active" @endif href="{{ route('frontend.product.index', array_merge(['page' => $page, 'category' => $cat['slug']], Input::all())) }}">{{ $cat->name }}</a></li>
									</div>
								@endforeach	
							</ul>						      		
				      	</div>
			   		</div>
			  	</div>
			</div>

			<div id="modalTag" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledbytag="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header modal-filter-title">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				       		<h4 class="modal-title" id="exampleModalLabel">Filter</h4>
				      	</div>
				      	<div class="modal-body ribbon-menu p-t-0">
							@foreach ($tag_types as $tag_type)
								@if($tag_type->category_id == 0)
									<ul class="list-inline m-b-none">
										<div class="col-xs-12 m-t-xs">
											<p class="ribbon-mobile-title"><span>{{ strtoupper($tag_type->name) }}</span></p>
										</div>
									</ul>	
									{{-- LIST OF TAGS --}}
									@foreach ($all_tags as $tag)
										@if ($tag_type->id == $tag->category_id)
											<ul class="list-inline m-b-none">
												<div class="col-xs-12">
													<li><a class='{{ $filters->where("value", $tag->slug)->count() ? "active": ""}}' href='{{ route("frontend.product.index", ["page" => $page] + array_except($current_tag, [$tag_type->slug]) + [$tag_type->slug => $tag->slug]) }}' class=''>{{ $tag->name }}</a></li>
												</div>
											</ul>
										@endif
									@endforeach
						      	@endif
							@endforeach	
				      	</div>
			   		</div>
			  	</div>
			</div>		

			<div id="modalFilter" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header modal-filter-title">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				       		<h4 class="modal-title" id="exampleModalLabel">Filter</h4>
				      	</div>
				      	<div class="modal-body ribbon-menu">
							<ul class="list-inline m-b-none">
								hjf
							</ul>						      		
				      	</div>
			   		</div>
			  	</div>
			</div>					

			<div id="modalSort" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header modal-filter-title">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				       		<h4 class="modal-title" id="exampleModalLabel">Urutkan</h4>
				      	</div>
				      	<div class="modal-body ribbon-menu">
							<ul class="list-inline m-b-none">
								<div class="col-xs-12">
									<li> <a @if(Input::get('sort')=='name-asc') class="active" @endif href="{{ route('frontend.product.index', array_merge(['page' => $page, 'sort' => 'name-asc'], Input::all())) }}">Nama Produk A-Z</a></li>
								</div>
								<div class="col-xs-12">
									<li> <a @if(Input::get('sort')=='name-desc') class="active" @endif href="{{ route('frontend.product.index', array_merge(['page' => $page, 'sort' => 'name-desc'], Input::all())) }}">Nama Produk Z-A</a></li>
								</div>
								<div class="col-xs-12">
									<li> <a @if(Input::get('sort')=='price-asc') class="active" @endif href="{{ route('frontend.product.index', array_merge(['page' => $page, 'sort' => 'price-asc'], Input::all())) }}">Harga Produk Termurah</a></li>
								</div>
								<div class="col-xs-12">
									<li> <a @if(Input::get('sort')=='price-desc') class="active" @endif href="{{ route('frontend.product.index', array_merge(['page' => $page, 'sort' => 'price-desc'], Input::all())) }}">Harga Produk Termahal</a></li>
								</div>
								<div class="col-xs-12">
									<li> <a @if(Input::get('sort')=='date-desc') class="active" @endif href="{{ route('frontend.product.index', array_merge(['page' => $page, 'sort' => 'date-desc'], Input::all())) }}">Produk Terbaru</a></li>
								</div>
								<div class="col-xs-12">
									<li> <a @if(Input::get('sort')=='date-asc') class="active" @endif href="{{ route('frontend.product.index', array_merge(['page' => $page, 'sort' => 'date-asc'], Input::all())) }}">Produk Terlama</a></li>
								</div>																
							</ul>						      		
				      	</div>
			   		</div>
			  	</div>
			</div>

			<div id="modalSearch" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header modal-filter-title">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				       		<h4 class="modal-title" id="exampleModalLabel">Cari</h4>
				      	</div>
				      	<div class="modal-body ribbon-menu">
				      		<div class="row">
							{!! Form::open(array('url' => route('frontend.product.index', Input::all()), 'method' => 'get', 'id' => 'form2', 'class' => 'form-group' )) !!}
								<div class="col-xs-9 p-r-none">
									{!! Form::text('name', null, ['class' => 'form-control hollow', 'style' => 'border-right:0;','placeholder' => 'Cari nama produk', 'required' => 'required']) !!}
								</div>
								<div class="col-xs-3 p-l-none">
									<button type="submit" tabindex="21" class="btn-hollow hollow-white-border btn-block t-sm" style="border-left:0; border: 1px solid #999;"><i class="fa fa-search"></i>&nbsp;</button>
								</div>
							{!! Form::close() !!}					      		
					      	</div>
				      	</div>
			   		</div>
			  	</div>
			</div>			
		</div>		
		<div class="row">
			<div class="col-md-12">
				{{-- @include('widgets.pageelements.headersearchresult', ['closeSearchLink' => route('frontend.product.index') ]) --}}
				@if (count($filters))
					<p class='m-t-md'>Menampilkan

{{-- 				@if ($filters->where('key', 'sort')->count())
						{{ $filters->where('key', 'sort')->first()['value'] }}
					@endif
 --}}
					@foreach ($filters as $filter)
						@if (!str_is('sort', $filter['key']))
							<?php 
								$filters_except_this=[];
								foreach ($filters->reject(function($item) use ($filter) { return $item['key'] == $filter['key']; }) as $kept_filters)
								{
									if (str_is('*.*', $kept_filters['key']))
									{
										$filters_except_this[explode('.', $kept_filters['key'])[1]] = $kept_filters['value'];
									}
									else
									{
										$filters_except_this[$kept_filters['key']] = $kept_filters['value'];
									}
								}
							?>
							<a href="{{ route('frontend.product.index') . '?'. http_build_query($filters_except_this) }}" class='p-l-xs p-r-xs'><i class='fa fa-times-circle'></i> {{ array_key_exists('object', $filter) ? $filter['object']->name : $filter['value'] }}</a>
						@endif
					@endforeach
					</p>
				@endif
			</div>
		</div>
			
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			@forelse($datas as $data)
				<div class="col-sm-4 col-md-3">
					@include('widgets.product_card')
				</div>
			@empty
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-md text-center">
				<?php $flag=0; ?>
					@if(!is_null($filters) && is_array($filters))
						@foreach ($filters as $key => $value)
							@if($key=='name')
								<?php $flag=1; ?>
							@endif
						@endforeach
					@endif
					@if ($flag==1)
						<h4>Maaf produk yang anda cari tidak ditemukan</h4>
					@else
						<h3 class="m-b-none">Coming Soon</h3><br><h4>Please stay tuned to be the first to know when our product is ready</h4>
					@endif
				</div>
			@endforelse
		</div>

		<div class="row">
			<div class="col-md-12 hollow-pagination" style="text-align:right;">
				<?Php 
				// {!! $datas->appends(Input::all())->render() !!}
				?>
				<div class="mt-5">
					@if (!isset($flag))
						@if(isset($route))
							{!! $paginator->links(Route::currentRouteName(), $route) !!}
						@else
							{!! $paginator->links(Route::currentRouteName(), Input::all()) !!}
						@endif
					@endif
				</div>						
			</div>
		</div>
	</div>
@stop


@section('script')
function setModalMaxHeight(element) {
	this.$element     = $(element);
	var dialogMargin  = $(window).width() > 767 ? 62 : 22;
	var contentHeight = $(window).height() - dialogMargin;
	var headerHeight  = this.$element.find('.modal-header').outerHeight() || 2;
	var footerHeight  = this.$element.find('.modal-footer').outerHeight() || 2;
	var maxHeight     = contentHeight - (headerHeight + footerHeight);

	this.$element.find('.modal-content').css({
		'overflow': 'hidden'
	});
  
	this.$element.find('.modal-body').css({
		'max-height': maxHeight,
		'overflow-y': 'auto'
	});
}

$('.modal').on('show.bs.modal', function() {
	$(this).show();
	setModalMaxHeight(this);
});

$(window).resize(function() {
	if ($('.modal.in').length != 0) {
		setModalMaxHeight($('.modal.in'));
	}
});

$('.menu-accordion').click(function(){
	$('.collapse-category').collapse("hide");
});

$('.collapse-category').on('show.bs.collapse', function(e){
	$('.menu-accordion').removeClass('active');
	$('#' + $(this).data('collapse')).addClass('active');
});

$('.collapse-category').on('hide.bs.collapse', function(e){
	$('.menu-accordion').removeClass('active');
});

$('#input-search').click(function(){
	$('.collapse-category').collapse("hide");
	$('.menu-accordion').removeClass('active');
});

$('.inp-search').focus( function() {
	$('.f-searching').addClass('focus');

}).focusout( function(){
	$('.f-searching').removeClass('focus');
});

@stop