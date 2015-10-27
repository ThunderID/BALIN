@inject('datas', 'App\Models\Product')
@inject('category', 'App\Models\Category')
<?php 
	$datas          = $datas->orderby('name')
						->paginate(12);
	$category       = $category::where('category_id', 0)
								->get();
?>

@extends('template.frontend.layout')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				@include('widgets.pageElements.pageTitle', ['pageTitle' => 'Products'])                  

				<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-12 pull-right">
						<p class="pull-right">Search</p>
					</div>                	                	
					<div class="col-md-2 col-sm-4 col-xs-12 pull-right">
						<p class="pull-right">Sort by</p>
					</div>
					<div class="col-md-1 col-sm-2 col-xs-12 pull-right">
						<div class="dropdown">
							<a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
								<p class="pull-right">Kategori</p>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dLabel">
								@foreach ($category as $cat)
									<li>{{ $cat->name }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				<div class="row carousel-holder">
				</div>

				<div class="row">
					@foreach($datas as $data)
						<div class="col-sm-4 col-md-3">
							@include('widgets.productCard')
						</div>
					@endforeach
				</div>

				<div class="row">
					<div class="col-md-12" style="text-align:right;">
						{!! $datas->appends(Input::all())->render() !!}
					</div>
				</div>

			</div>

		</div>

	</div>
@stop