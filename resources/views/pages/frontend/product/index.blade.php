@inject('datas', 'App\Models\Product')
@inject('category', 'App\Models\Category')
@inject('tag', 'App\Models\tag')
<?php 
	$perpage = 12;

	if(!is_null($filters) && is_array($filters))
	{
		foreach ($filters as $key => $value) 
		{
			$datas 	= call_user_func([$datas, $key], $value);
		}
	}

	$totalItems 	= $datas->count();
	
	$paginator 		= new PrettyPaginate($totalItems , (int)$page, $perpage, count($datas));

	$datas 			= $datas->currentprice(true)->DefaultImage(true)->sellable(true)->orderby('products.created_at','desc')->take($perpage)->skip(($page-1) * $perpage)->get();

	$category      	= $category::where('category_id', 0)
								->get();

	$tag      		= $tag::orderby('path', 0)
								->get();								
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container m-t-sm">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				@include('widgets.breadcrumb')
			</div>
		</div>

		<div class="row m-t-0 m-b-sm">
			<div class="container">
				<div class="col-md-12 col-sm12 hidden-xs">
					<div class="row ribbon">
						<div class="col-md-7 col-sm-9 p-l-xxs">
							<ul class="list-inline ribbon-menu m-b-none">
								<li>
							        <a role="button" id="collapse1" class="menu-accordion"  data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
										KATEGORI <i class="fa fa-chevron-circle-down pull-right"></i>
							        </a>									
								</li>						
								<li>
							        <a role="button" id="collapse2" class="menu-accordion"  data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										TAG <i class="fa fa-chevron-circle-down pull-right"></i>
									</a>
								</li>
								<li>
							        <a role="button" id="collapse3" class="menu-accordion"  data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										FILTER <i class="fa fa-chevron-circle-down pull-right"></i>
									</a>
								</li>
								<li>
							        <a role="button" id="collapse4" class="menu-accordion"  data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
										SORT BY <i class="fa fa-chevron-circle-down pull-right"></i>
									</a>
								</li>
							</ul>
						</div>
						<div class="col-md-5 col-sm-3 p-l-xxs text-right">
							<div class="row">
							{!! Form::open(array('url' => route('frontend.product.index', Input::all()), 'method' => 'get', 'id' => 'form1', 'class' => 'form-group' )) !!}
								<div class="col-xs-10 p-r-none">
									{!! Form::text('name', null, ['class' => 'form-control hollow', 'style' => 'border-right:0; border-top:0; border-bottom:0; height: 42px; padding-top:6px;','placeholder' => 'Search']) !!}
								</div>
								<div class="col-xs-2 p-l-none p-r-none p-b-none">
									<a href="#" onclick="form1.submit();" type="button" class="btn-hollow hollow-white-border btn-block t-sm" style="border-left:0; border: 1px solid #999; border-top:0; border-bottom:0; height: 42px;"><i class="fa fa-search" style="padding-top:6px;"></i></a>
								</div>
					      	</div>
							{!! Form::close() !!}
						</div>																								
					</div>

					<div class="row collapse collapse-category" id="collapseOne" data-collapse="collapse1" aria-expanded="true">
						<div class="col-md-12 p-l-xxs ribbon-submenu">
							<div class="row p-sm">
								<ul class="list-inline m-b-none">
								@foreach ($category as $cat)
									<div class="col-md-3 col-sm-4">
										<li><a href="{{ route('frontend.product.index', array_merge(['q' => $cat->name], Input::all())) }}">{{ $cat->name }}</a></li>
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
									@foreach ($tag as $tg)
										@if($tg->category_id == 0)
											<div class="col-md-12 col-sm-12 text-white">
												<p class="ribbon-title">{{ strtoupper($tg->name) }}</p>
											</div>
											@foreach ($tag as $tmp)
												@if($tg->id == $tmp->category_id)
													<div class="col-md-3 col-sm-4">
														<li><a href="{{ route('frontend.product.index', array_merge(Input::all(), ['page' => $page,'tagname' => $tmp->name])) }}">{{ $tmp->name }}</a></li>
													</div>
										      	@endif
											@endforeach													
								      	@endif
									@endforeach											
								</ul>					
							</div>						
						</div>						
					</div>


					<div class="row collapse collapse-category" id="collapseThree" data-collapse="collapse3" aria-expanded="true">
						<div class="col-md-12 p-l-xxs ribbon-submenu">
							<ul class="list-inline m-b-none">
								<li><a href="#">Dummmyyyyy</a></li>
							</ul>					
						</div>						
					</div>

					<div class="row collapse collapse-category" id="collapseFour" data-collapse="collapse4" aria-expanded="true">
						<div class="col-md-12 p-l-xxs ribbon-submenu">
							<div class="row p-sm">
								<ul class="list-inline m-b-none">
									<div class="col-md-3 col-sm-4">
										<li><a href="{{ route('frontend.product.index', array_merge(['sort' => 'asc'], Input::all())) }}">A-Z</a></li>
									</div>
									<div class="col-md-3 col-sm-4">
										<li><a href="{{ route('frontend.product.index', array_merge(['sort' => 'desc'], Input::all())) }}">Z-A</a></li>
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
							TAG <i class="fa fa-chevron-circle-right pull-right"></i>
							</a>
						</li>
						<li>
							<a href="#" data-toggle="modal" data-target="#modalFilter">									
							FILTER <i class="fa fa-chevron-circle-right pull-right"></i>
							</a>
						</li>
						<li>
							<a href="#" data-toggle="modal" data-target="#modalSort">									
							SORT BY <i class="fa fa-chevron-circle-right pull-right"></i>
							</a>
						</li>
						<li>
							<a href="#" data-toggle="modal" data-target="#modalSearch">									
							SEARCH <i class="fa fa-search pull-right"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div id="modalCategory" class="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				       		<h4 class="modal-title" id="exampleModalLabel">Kategori</h4>
				      	</div>
				      	<div class="modal-body ribbon-menu">
							<ul class="list-inline m-b-none">
								@foreach ($category as $cat)
									<div class="col-xs-12">
										<li><a href="{{ route('frontend.product.index', array_merge(['q' => $cat->name], Input::all())) }}">{{ $cat->name }}</a></li>
									</div>
								@endforeach	
							</ul>						      		
				      	</div>
			   		</div>
			  	</div>
			</div>

			<div id="modalTag" class="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				       		<h4 class="modal-title" id="exampleModalLabel">Tag</h4>
				      	</div>
				      	<div class="modal-body ribbon-menu p-t-0">
							@foreach ($tag as $tg)
								@if($tg->category_id == 0)
									<ul class="list-inline m-b-none">
										<div class="col-xs-12 m-t-xs">
											<p class="ribbon-mobile-title"><span>{{ strtoupper($tg->name) }}</span></p>
										</div>
									</ul>									
									@foreach ($tag as $tmp)
										@if($tg->id == $tmp->category_id)
											<ul class="list-inline m-b-none">
												<div class="col-xs-12">
													<li><a href="{{ route('frontend.product.index', array_merge(['tagname' => $tmp->name], Input::all())) }}">{{ $tmp->name }}</a></li>
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

			<div id="modalFilter" class="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header">
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

			<div id="modalSort" class="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				       		<h4 class="modal-title" id="exampleModalLabel">Sort By</h4>
				      	</div>
				      	<div class="modal-body ribbon-menu">
							<ul class="list-inline m-b-none">
								<div class="col-xs-12">
									<li><a href="{{ route('frontend.product.index', array_merge(['sort' => 'asc'], Input::all())) }}">A-Z</a></li>
								</div>
								<div class="col-xs-12">
									<li><a href="{{ route('frontend.product.index', array_merge(['sort' => 'desc'], Input::all())) }}">Z-A</a></li>
								</div>
							</ul>						      		
				      	</div>
			   		</div>
			  	</div>
			</div>

			<div id="modalSearch" class="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  	<div class="modal-dialog modal-sm dialog-mobile">
			    	<div class="modal-content">
						<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				       		<h4 class="modal-title" id="exampleModalLabel">Search</h4>
				      	</div>
				      	<div class="modal-body ribbon-menu">
				      		<div class="row">
							{!! Form::open(array('url' => route('frontend.product.index', Input::all()), 'method' => 'get', 'id' => 'form2', 'class' => 'form-group' )) !!}
								<div class="col-xs-9 p-r-none">
									{!! Form::text('name', null, ['class' => 'form-control hollow', 'style' => 'border-right:0;','placeholder' => 'Search']) !!}
								</div>
								<div class="col-xs-3 p-l-none">
									<a href="#" onclick="form2.submit();" type="button" class="btn-hollow hollow-white-border btn-block t-sm" style="border-left:0; border: 1px solid #999;"><i class="fa fa-search"></i></a>
								</div>
					      	</div>
							{!! Form::close() !!}					      		
				      	</div>
			   		</div>
			  	</div>
			</div>			
		</div>		

		<div class="row">
			<div class="col-md-12">
				@include('widgets.pageelements.headersearchresult', ['closeSearchLink' => route('frontend.product.index') ])
			</div>
		</div>


		<div class="row carousel-holder">
		</div>
			
		<div class="row">
			@foreach($datas as $data)
				<div class="col-sm-4 col-md-3">
					@include('widgets.product_card')
				</div>
			@endforeach
		</div>

				<div class="row">
					<div class="col-md-12 hollow-pagination" style="text-align:right;">
						<?Php 
						// {!! $datas->appends(Input::all())->render() !!}
						?>
						<div class="mt-5">
							@if(isset($route))
								{!! $paginator->links(Route::currentRouteName(), $route) !!}
							@else
								{!! $paginator->links(Route::currentRouteName(), Input::all()) !!}
							@endif
						</div>						
					</div>
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

  this.$element
    .find('.modal-content').css({
      'overflow': 'hidden'
  });
  
  this.$element
    .find('.modal-body').css({
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

@stop