{!! HTML::style('Balin/admin/plugin/select2/select2.css') !!}
{!! HTML::script('Balin/admin/plugin/select2/select2.js') !!}

<script>
	$('.select2').select2();

	$('.select-category').select2({
		placeholder: 'Masukkan nama kategori',
		minimumInputLength: 3,
		tags: false,
		ajax: {
			url: "{{ route('backend.category.ajax.getByName') }}",
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
	$('.select-category').select2('data', preload_data );

	$('.select-customer').select2({
		placeholder: 'Masukkan nama customer',
		minimumInputLength: 2,
		tags: false,
		ajax : {
			url: "{{ route('backend.customer.ajax.getCustomerByName') }}",
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
							address: item.address,
							phone: item.phone,
							postalcode: item.postal_code
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
		$('.transaction-input-address').val(e.object.address);
		$('.transaction-input-postal-code').val(e.object.postalcode);
		$('.transaction-input-phone').val(e.object.phone);
		$('.label-name').text(e.object.text);
	});

	$('.select-customer').select2('data', preload_data );

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
	$('.select-product-by-name').select2('data', preload_data );

	$('.select-method-transaction').on('change', function() {
		var value = $(this).val();
		if (value==='point_log') {
			$('div.no-rek').hide();
			$('div.point').show();
		}
		else 
		{
			$('div.point').hide();
			$('div.no-rek').show();
		}
		$('.wizard .content').animate({ height: $('.body.current').outerHeight() }, "slow");
	});

	$('.select-courier-by-name').select2({
		placeholder: 'Masukkan nama Courier',
		minimumInputLength: 2,
		maximumSelectionSize: 1,
		tags: false,
		ajax : {
			url: "{{ route('backend.courier.ajax.getCourierByName') }}",
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
	$('.select-courier-by-name').select2('data', preload_data );

	$('.select-supplier-by-name').select2({
		placeholder: 'Masukkan nama Supplier',
		minimumInputLength: 2,
		maximumSelectionSize: 1,
		tags: false,
		ajax : {
			url: "{{ route('backend.supplier.ajax.getSupplierByName') }}",
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
	$('.select-supplier-by-name').select2('data', preload_data );

	$('.select-transaction').select2({
		placeholder: 'Masukkan jumlah transaksi',
		minimumInputLength: 3,
		tags: false,
		ajax: {
			url: "{{ route('backend.transaction.ajax.getByAmount') }}",
			dataType: 'json',
			data: function (term, path) {
				return {
					name: term,
				};
			},
		   results: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.user.name+' #'+item.ref_number+' ('+item.total_paid+')',
							id: item.id +' ',
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
	});
	$('.select-transaction').select2('data', preload_data );
</script>