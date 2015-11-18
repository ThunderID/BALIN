@inject('datas', 'App\Models\Product')
@inject('category', 'App\Models\Category')
<?php 
	if(!is_null($filters) && is_array($filters))
	{
		foreach ($filters as $key => $value) 
		{
			$datas 	= call_user_func([$datas, $key], $value);
		}
	}
	$datas 			= $datas->currentprice(true)->DefaultImage(true)->sellable(true)->paginate(12);
	$category      = $category::where('category_id', 0)
								->get();
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container mt-75">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-md-6 col-sm-7 col-xs-12">
						@include('widgets.breadcrumb')
						@include('widgets.pageelements.headersearchresult', ['closeSearchLink' => route('frontend.product.index') ])
					</div>
						<div class="col-md-3 col-sm-6 hidden-xs pull-right m-t-lg">
							{!! Form::open(array('url' => route('frontend.product.index', Input::all()), 'method' => 'get', 'id' => 'form1' )) !!}
								<a href="#" onclick="form1.submit();" class="pull-right"><i class="fa fa-search"></i></a>
								{!! Form::text('name', null, ['class' => 'text-hollow pull-right', 'placeholder' => 'Search', 'style' => 'width:80%']) !!}
							{!! Form::close() !!}
						</div>
						<div class="hidden-lg hidden-md hidden-sm col-xs-12 pull-right m-t-lg">
							{!! Form::open(array('url' => route('frontend.product.index', Input::all()), 'method' => 'get', 'id' => 'form2' )) !!}
								<a href="#" onclick="form2.submit();" class="pull-right"><i class="fa fa-search"></i></a>
								{!! Form::text('name', null, ['class' => 'text-hollow pull-left', 'placeholder' => 'Search', 'style' => 'width:94%']) !!}
							{!! Form::close() !!}
						</div>
					<div class="col-md-1 col-sm-2 hidden-xs pull-right m-t-lg">
						<div class="dropdown">
							<a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
								<p class="pull-right">Sort by &nbsp;<i class="fa fa-angle-down"></i></p>
							</a>
							<ul class="dropdown-menu category-list" aria-labelledby="dLabel">
								<li><a href="{{ route('frontend.product.index', array_merge(['sort' => 'asc'], Input::all())) }}">A-Z</a></li>
								<li><a href="{{ route('frontend.product.index', array_merge(['sort' => 'desc'], Input::all())) }}">Z-A</a></li>
							</ul>
						</div>
					</div>		
					<div class="col-md-2 col-sm-2 hidden-xs pull-right m-t-lg">
						<div class="dropdown">
							<a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
								<p class="pull-right">Kategori &nbsp;<i class="fa fa-angle-down"></i></p>
							</a>
							<ul class="dropdown-menu category-list" aria-labelledby="dLabel">
								@foreach ($category as $cat)
									<li><a href="{{ route('frontend.product.index', array_merge(['q' => $cat->name], Input::all())) }}">{{ $cat->name }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
					<div clas="hidden-lg hidden-sm hidden-md col-xs-12">
						<div class="hidden-lg hidden-sm hidden-md col-xs-6 pull-right m-t-sm">
							<a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
								<p class="pull-right"> <i class="fa fa-angle-down"></i>  &nbsp; Kategori</p>
							</a>
							<ul class="dropdown-menu category-list m-t-0" aria-labelledby="dLabel">
								@foreach ($category as $cat)
									<li><a href="{{ route('frontend.product.index', array_merge(['q' => $cat->name], Input::all())) }}">{{ $cat->name }}</a></li>
								@endforeach
							</ul>							
						</div>
						<div class="hidden-lg hidden-sm hidden-md col-xs-6 pull-left m-t-sm">
							<a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
								<p class="pull-left">Sort by  &nbsp; <i class="fa fa-angle-down"></i> </p>
							</a>							
							<ul class="dropdown-menu category-list m-t-0" aria-labelledby="dLabel">
								<li><a href="{{ route('frontend.product.index', array_merge(['sort' => 'asc'], Input::all())) }}">A-Z</a></li>
								<li><a href="{{ route('frontend.product.index', array_merge(['sort' => 'desc'], Input::all())) }}">Z-A</a></li>
							</ul>							
						</div>							
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
						{!! $datas->appends(Input::all())->render() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@stop