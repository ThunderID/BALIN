<script>
	$('.btn-add').click(function () {
		

		


	});
	$('.btn-add').click(function() {template_add_product($(this))});
	function template_add_product(e)
	{
		var tmp = '';
		tmp 	+= '<div class="row"> \
						<div class="col-md-4"> \
							<div class="form-group"> \
								<label>Produk</label> \
								<input type="text" name="product[]" class="select-product-by-name" style="width:100%" /> \
							</div> \
						</div> \
						<div class="col-md-1"> \
							<div class="form-group"> \
								<label>Qty</label> \
								<input type="text" name="qty" class="form-control" /> \
							</div> \
						</div> \
						<div class="col-md-2"> \
							<div class="form-group"> \
								<label for="harga">Harga</label> \
								<input type="text" name="price" class="form-control price" /> \
							</div> \
						</div> \
						<div class="col-md-2"> \
							<div class="form-group"> \
								<label for="diskon">Diskon</label> \
								<input type="text" name="discount" class="form-control" /> \
							</div> \
						</div> \
						<div class="col-md-2"> \
							<div class="form-group"> \
								<label for="harga">Jumlah Harga</label> \
								<input type="text" name="tot_price" class="form-control" /> \
							</div> \
						</div> \
						<div class="col-md-1"> \
							<div class="form-group"> \
								<a href="javascript:;" class="btn btn-sm btn-default m-t-mds btn-add"> \
									<i class="fa fa-plus"></i> \
								</a> \
							</div> \
						</div> \
					</div>';

		$('#template').append(tmp);
		$('.btn-add').click(function() {template_add_product($(this))});
		$('.wizard .content').animate({ height: $('.body.current').outerHeight() }, "slow");

		$('.select-product-by-name').select2({
			placeholder: 'Masukkan nama product',
			minimumInputLength: 2,
			maximumSelectionSize: 1,
			tags: false,
			ajax : {
				url: "{{ route('backend.product.ajax.getProductByName') }}",
				dataType: 'json',
				data: function (term, path) {
					return {
						name: term,
						path : '{{ isset($data['path']) ? $data['path'] : '' }}'
					};
				},
			   results: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								text: item.name +' ',
								id: item.id +' ',
								path: item.path
							}
							$('.price').val(item.price);
							// $(this).attr('data-price', item.price);
						})
					};
				},
				query: function (query){
					var data = {results: []};
					 
					$.each(preload_data, function(){
						if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
							data.results.push({id: this.id, text: this.text });
						}
					});
		
					query.callback(data);
				}	
			}
		});
		$('.select-product-by-name').select2('data', preload_data );
		change_button_add(e);
	}

	function change_button_add(e)
	{
		var btn 			= '';
		var btn_template 	= $(e).parent();

		e.remove();
		btn 				+= '<a href="javascript:;" class="btn btn-sm btn-default m-t-mds btn-del"><i class="fa fa-minus"></i></a>';

		btn_template.html(btn);
		$('.btn-del').click(function() {template_del_product($(this))});
	}

	$('.btn-del').click(function() {template_del_product($(this))});
	function template_del_product(e)
	{
		e.parent().parent().parent().remove();
		$('.wizard .content').animate({ height: $('.body.current').outerHeight() }, "slow");
		$('.btn-del').click(function() {template_del_product($(this))});
	}
</script>