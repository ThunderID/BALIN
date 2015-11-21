@inject('data', 'App\Models\Product')
<?php 
	$data 			= $data::where('id', $id)->with('lables')->with('categories')->with('images')->first();
	$date 			= null;
	$price	 		= null;
	$promo_price 	= null;
	$tmp_img		= null;
	$images 		= $data['images'];
	$lables 		= [];
?>

@if($data)
	<?php 
		$date 			= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->startedAt)->format('d-m-Y H:i'); 
		$price 			= $data->price;
		$promo_price	= $data->promoprice;

		foreach ($data['lables'] as $value) {
			array_push($lables, ($value['lable']));
		}		
	?>
@endif	

@extends('template.backend.layout') 

@section('content')
	@if(!is_null($id))
		{!! Form::open(['url' => route('backend.data.product.update', ['id' => $id] ), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('backend.data.product.store'), 'method' => 'POST', 'id' => 'my-awesome-dropzone', 'class' => 'dropzone']) !!}
	@endif
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Produk
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="name">Nama Produk</label>
					{!! Form::text('name', $data['name'], [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan nama produk'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="upc">UPC</label>
					{!! Form::text('upc', $data['upc'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan kode UPC',
								'tabindex'      => '2', 
					]) !!}
				</div>
			</div>                                         
		</div>
		<?php
			if(is_null($id))
			{
				$product['description'] = null;
				$product['fit'] 		= null;
			}
			else
			{
				$product 				= json_decode($data['description'], true);
			}
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="description">Deskripsi</label>
					{!! Form::textarea('description', $product['description'], [
								'class'         => 'summernote form-control', 
								'placeholder'   => 'Masukkan deskripsi',
								'rows'          => '1',
								'tabindex'      => '3',
								'style'         => 'resize:none;',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="fit">Ukuran & Fit</label>
					{!! Form::textarea('fit', $product['fit'], [
								'class'         => 'summernote form-control', 
								'placeholder'   => 'Masukkan ukuran',
								'rows'          => '1',
								'tabindex'      => '4',
								'style'         => 'resize:none;',
					]) !!}
				</div>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Filter
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="category">Kategori <small><a href="{{route('backend.settings.category.create')}}" target="blank">Baru</a></small></label>
					{!! Form::text('category', null, [
								'class'         => 'select-category', 
								'tabindex'      => '5',
								'id'            => 'find_category',
								'style'         => 'width:100%',
					]) !!}
				</div>  
			</div> 
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="tag">Tag <small><a href="{{route('backend.settings.tag.create')}}" target="blank">Baru</a></small></label>
					{!! Form::text('tag', null, [
								'class'         => 'select-tag', 
								'tabindex'      => '6',
								'id'            => 'find_tag',
								'style'         => 'width:100%',
					]) !!}
				</div>  
			</div> 
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Harga
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">Harga</label>
					{!! Form::text('price', $price, [
								'class'        		=> 'form-control money', 
								'tabindex'     		=> '7', 
								'placeholder'  		=> 'harga',
					]) !!}
				</div>  
			</div>  
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">Harga Promo</label>
					{!! Form::text('promo_price', $promo_price, [
								'class'         => 'form-control money', 
								'tabindex'      => '8', 
								'placeholder'   => '(kosongkan bila tidak ada promo)'
					]) !!}
				</div>  
			</div> 		
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">Mulai</label>
					{!! Form::text('started_at', $date, [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '9', 
								'placeholder'   => 'dd-mm-yyyy hh:mm'
					]) !!}
				</div>  
			</div> 
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Campaign
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-6">
				@if (in_array("new_item", $lables))
					<?php $val = true; ?>
				@else
					<?php $val = false; ?>
				@endif
				{!! Form::checkbox('label[]' ,'new_item', $val, [
								'class' 		=> '',
								'tabindex'      => '10',
				]) !!}
				<label for="new_item">New Item</label>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-6">
				@if (in_array("best_seller", $lables))
					<?php $val = true; ?>
				@else
					<?php $val = false; ?>
				@endif				
				{!! Form::checkbox('label[]' ,'best_seller', $val, [
								'class' 		=> '',
								'tabindex'      => '11',
				]) !!}	
				<label for="best_seller">Best Seller</label>
			</div>			
			<div class="col-md-3 col-sm-3 col-xs-6">
				@if (in_array("sale", $lables))
					<?php $val = true; ?>
				@else
					<?php $val = false; ?>
				@endif					
				{!! Form::checkbox('label[]' ,'sale', $val, [
								'class' 		=> '',
								'tabindex'      => '12',
				]) !!}	
				<label for="sale">Sale</label>
			</div>			
			<div class="col-md-3 col-sm-3 col-xs-6">
				@if (in_array("hot_item", $lables))
					<?php $val = true; ?>
				@else
					<?php $val = false; ?>
				@endif					
				{!! Form::checkbox('label[]' ,'hot_item', $val, [
								'class' 		=> '',
								'tabindex'      => '13',
				]) !!}	
				<label for="hot_item">Hot Item</label>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>

		<div class="hidden">
			<div id="tmplt">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="thumbnail" class="text-capitalize">URL Image (320 X 463 px)</label>
							{!! Form::text('thumbnail[]', null, [
										'class'         => 'form-control input-image-thumbnail', 
										'tabindex'      => '14',
										'placeholder'   => 'Masukkan url image thumbnail',
							]) !!}
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="logo" class="text-capitalize">URL Image (320 X 463 px)</label>
							{!! Form::text('image_xs[]', null, [
										'class'         => 'form-control input-image-xs', 
										'tabindex'      => '15',
										'placeholder'   => 'Masukkan url image xs',
							]) !!}
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="logo" class="text-capitalize">URL Image (320 X 463 px)</label>
							{!! Form::text('image_sm[]', null, [
										'class'         => 'form-control input-image-sm', 
										'tabindex'      => '16',
										'placeholder'   => 'Masukkan url image sm',
							]) !!}
						</div>
					</div>											
					<div class="col-md-4">
						<div class="form-group">
							<label for="logo" class="text-capitalize">URL Image (772 X 1043 px)</label>
							{!! Form::text('image_md[]', null, [
										'class'         => 'form-control input-image-md', 
										'tabindex'      => '17',
										'placeholder'   => 'Masukkan url image md',
							]) !!}
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="logo" class="text-capitalize">URL Image (992 X 1434 px)</label>
							{!! Form::text('image_lg[]', null, [
										'class'         => 'form-control input-image-lg', 
										'tabindex'      => '18',
										'placeholder'   => 'Masukkan url image lg',
							]) !!}							
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">					
							<label for="default" class="text-capitalize">Default</label>
							<select name="default[]" class="form-control default" tabindex="19">
						        <option value="0" selected="selected">False</option>
						        <option value="1" >True</option>
							</select>							
						</div>						
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<a href="javascript:;" class="btn btn-sm btn-default m-t-mds btn-add-image pull-left">
								<i class="fa fa-plus"></i>
							</a>
						</div>
					</div>					
				</div>
			</div>
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Gambar
				</h4>
			</div>
		</div>

		<div id="template-image">
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('backend.data.product.show') }}" class="btn btn-md btn-default" tabindex="20">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="21">Simpan</button>
				</div>        
			</div>        
		</div>        
	{!! Form::close() !!}   
@stop


@section('script')
	$( document ).ready(function() {

		<!-- microtemplate start -->

		<!-- load microtemplate -->
		@if(count($images) > 0)
			$('#tmplt').find('.input-image-thumbnail').val('{{$images[0]['thumbnail']}}');
			$('#tmplt').find('.input-image-lg').val('{{$images[0]['image_lg']}}');
			$('#tmplt').find('.input-image-md').val('{{$images[0]['image_md']}}');
			$('#tmplt').find('.input-image-sm').val('{{$images[0]['image_sm']}}');
			$('#tmplt').find('.input-image-xs').val('{{$images[0]['image_xs']}}');
			$('#tmplt').find('.default').val({{$images[0]['is_default']}});
		@endif

		template_add_image($('.base'));
		
		<!-- push image datas -->
		@if(count($images)>= 1)
			@for($key=1; $key < count($images); $key++)
				console.log({{$key}});
				$('#tmplt').find('.input-image-thumbnail').val('{{$images[$key]['thumbnail']}}');
				$('#tmplt').find('.input-image-lg').val('{{$images[$key]['image_lg']}}');
				$('#tmplt').find('.input-image-md').val('{{$images[$key]['image_md']}}');
				$('#tmplt').find('.input-image-sm').val('{{$images[$key]['image_sm']}}');
				$('#tmplt').find('.input-image-xs').val('{{$images[$key]['image_xs']}}');
				$('#tmplt').find('.default').val({{$images[$key]['is_default']}});

				$('#template-image').find('.btn-add-image').trigger('click');
			@endfor
		@endif

		@if(count($images) > 0)
			$('#tmplt').find('.input-image-thumbnail').val('');
			$('#tmplt').find('.input-image-lg').val('');
			$('#tmplt').find('.input-image-md').val('');
			$('#tmplt').find('.input-image-sm').val('');
			$('#tmplt').find('.input-image-xs').val('');
			$('#tmplt').find('.default').val(0);

			$('#template-image').find('.btn-add-image').trigger('click');
		@endif
		<!-- microtemplate end -->

		<!-- image default validator -->
		$('#template-image').find('.default').on('change', function() {
			if(this.value == 1)
			{
				$('#template-image').find('.default').val(0);
				$(this).val(1);
			}
		});


		var tmplt      =   $("#attributeTemplate").html();

		$("#items").append(tmplt);
	});


	$("#add").click(function (e) {
		var tmplt      =   $("#attributeTemplate").html();

		$("#items").append(tmplt);
	});

	$("body").on("click", ".delete", function (e) {
		$(this).parent("div").parent("div").remove();
	});    

	var preload_data = [];

	selections = [
		@if ($data['categories'])
			@foreach($data['categories'] as $category)
				{ 
					id:{{$category['id']}},
					text:'{{$category['name']}}'
				},
			@endforeach
		@endif
	];

	for (i = 0; i < selections.length; i++) { 
		preload_data.push(selections[i]);         
	}
	
	var preload_data_tag = [];

	selections = [
		@if ($data['tags'])
			@foreach($data['tags'] as $category)
				{ 
					id:{{$category['id']}},
					text:'{{$category['name']}}'
				},
			@endforeach
		@endif
	];

	for (i = 0; i < selections.length; i++) { 
		preload_data_tag.push(selections[i]);         
	}		 
@stop

@section('script_plugin')
	@include('plugins.select2')
	@include('plugins.summernote')
	@include('plugins.input-mask')
	@include('plugins.microtemplate')
	<script>

	// 	$( document ).ready(function() {
	// 		console.log(22);
	// 		$('.btn-add').trigger("click");

	// 		// template_add_product($(this));
	// 	});
	</script>
@stop