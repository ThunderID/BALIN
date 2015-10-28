<script>
	$(document).ready(function() {template_add_product($('.base'))});

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
								<input type="text" name="qty[]" class="form-control text-center transaction-input-qty" /> \
							</div> \
						</div> \
						<div class="col-md-2"> \
							<div class="form-group"> \
								<label for="harga">Harga</label> \
								<input type="text" name="price[]" class="form-control text-right transaction-input-price" @if(Input::get("type")!="buy") readonly @endif/> \
							</div> \
						</div> \
						<div class="col-md-2"> \
							<div class="form-group"> \
								<label for="diskon">Diskon</label> \
								<input type="text" name="discount[]" class="form-control text-right transaction-input-discount" @if(Input::get("type")!="buy") readonly @endif/> \
							</div> \
						</div> \
						<div class="col-md-2"> \
							<div class="form-group"> \
								<label for="harga">Jumlah Harga</label> \
								<input type="text" name="tot_price[]" class="form-control text-right transaction-input-jum-price" /> \
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
			minimumInputLength: 4,
			maximumSelectionSize: 1,
			tags: false,
			ajax : {
				url: "{{ route('backend.product.ajax.getProductByName') }}",
				dataType: 'json',
				data: function (term, path) {
					return {
						name: term
					};
				},
			   results: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								text: item.name +' ',
								id: item.id +' ',
								price: item.price,
								discount: item.discount,
							}
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
		}).on("select2-selecting", function(e) {
			$(this).parent().parent().parent().find('.transaction-input-price').val(e.object.price);
			$(this).parent().parent().parent().find('.transaction-input-discount').val(e.object.discount);
		});

		change_button_add(e);

		$('.transaction-input-qty').on('change', function()
		{
			var qty = $(this).val();
			var price_jum = 0;
			var price = parseInt($(this).parent().parent().parent().find('.transaction-input-price').val());
			var discount = parseInt($(this).parent().parent().parent().find('.transaction-input-discount').val());

			price_jum = (price-discount)*qty;

			$(this).parent().parent().parent().find('.transaction-input-jum-price').val(price_jum);

		});
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