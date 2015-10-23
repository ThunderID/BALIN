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
	$('.select-customer').select2('data', preload_data );

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
</script>