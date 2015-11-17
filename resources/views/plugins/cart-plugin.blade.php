<script type="text/javascript">
	// Add to Cart
	$('.addto-cart').on('click', function() {
		var pvarians 	= [];
		var pqty 		= [];
		var fcart 		= $('.form-addtocart');
		var pslug 		= $('.pslug').val();
		var pname 		= $('.pname').val();
		var count_cart 	= 0;

		fcart.attr('action', 'javascript:void(0);');
		$('.pqty').each( function() {
			pqty.push($(this).val());
		});
		$('.pvarians').each( function() {
			pvarians.push($(this).val());
		});

		$.ajax({
			url: '{{ route('frontend.cart.store.ajax') }}',
			type: 'POST',
			dataType:"json",
			data: {product_slug: pslug, product_name: pname, qty: pqty, varianids: pvarians},
			beforeSend: function() {
				$('.addto-cart').val('ADDING...');
			},
			success: function(result) {
				count_cart = Object.keys(result.carts).length; 
				$('.addto-cart').val('ADD TO CART');
				$('.ico-cart').find('span').html(count_cart);
				$.ajax({
					url: '{{ route('frontend.cart.listBasket.ajax') }}',
					beforeSend: function() {
						$('chart-dropdown').html("<img src='/Balin/web/image/loading.gif'/>");
					},
					success: function(msg) {
						$('.chart-dropdown').html(msg);
					}
				});
			}
		});
	});

	$('.btn-delete-item').on('click', function() {
		var action = $(this).attr('data-action');
		$.ajax({
			url: action,
			type: 'POST',
			dataType:"json",
			success: function(result) {
				$(this).parent().parent().parent().parent().remove();
				count_cart = Object.keys(result.carts).length; 
				$('.addto-cart').val('ADD TO CART');
				$('.ico-cart').find('span').html(count_cart);
				$.ajax({
					url: '{{ route('frontend.cart.listBasket.ajax') }}',
					success: function(msg) {
						$('.chart-dropdown').html(msg);
					}
				});
			}

		});
	});

	$('.btn-delete-varian').on('click', function() {
		var row 	= $(this).parent().parent();
		var flag 	= row.attr('data-get-flag');
		var action 	= $(this).attr('data-action'); 
		var cid 	= $(this).data('cid');
		var vid 	= $(this).data('vid');

		$.ajax({
			url: '{{ route('frontend.cart.destroy') }}',
			type: 'POST',
			dataType:"json",
			data: {cid: cid, vid: vid},
			success: function(result) {
				$(row).siblings('.'+flag).remove();
				$(row).remove();

				count_cart = Object.keys(result.carts).length; 
				$('.ico-cart').find('span').html(count_cart);

				$.ajax({
					url: '{{ route('frontend.cart.listBasket.ajax') }}',
					success: function(msg) {
						$('.chart-dropdown').html(msg);
					}
				});
			}
		});
	});
</script>