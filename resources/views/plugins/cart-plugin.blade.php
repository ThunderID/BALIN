<script type="text/javascript">
	var tot_qty 	= 0;
	var gtotal 		= 0;
	var item_qty 	= 0;
	var pqty 		= [];
	var flg 		= 0;

	@if (Route::is('frontend.cart.index'))
	@endif

	var tot_qty_mobile = 0;

	// FOR DESKTOP
	$('.btn-number').on('click',function(e){
		e.preventDefault();
		$(this).parent().parent().parent().attr('action', 'javascript:void(0);');

		fieldName 				= $(this).attr('data-field');
		type      				= $(this).attr('data-type');

		@if (Route::is('frontend.cart.index'))
			var cid 				= $(this).attr('data-cid');
			var vid 				= $(this).attr('data-vid');

			var list_cart_mobile 	= $('.list-vid-mobile[data-vid="'+vid+'"][data-cid="'+cid+'"]');

			var input 				= $(this).parent().parent().find('.input-number').attr('data-name', fieldName);
			var lab_total  			= input.parent().parent().parent().parent().parent().parent().find('.label-total');

			var input_mobile 		= list_cart_mobile.find('.input-number-mobile[data-name="'+fieldName+'"]');
			var lab_total_mobile 	= input_mobile.parent().parent().parent().parent().parent().find('.label-total-mobile');

			var action_update 		= $(this).attr('data-action-update');
			var varian_qty 			= 0;
		@else
			var input 				= $(this).parent().find('.input-number').attr('data-name', fieldName);
		@endif

		var currentVal = parseInt(input.val());

		if (!isNaN(currentVal)) {
			if(type == 'minus') {
				if(currentVal > input.attr('min')) {
					@if (Route::is('frontend.cart.index'))
						qty_minus(input, currentVal, lab_total, type);
						qty_minus_mobile(input_mobile, currentVal, lab_total_mobile, type);
						disable_btn($(this), input, vid, cid);

						varian_qty = currentVal-1;
					@else
						qty_minus_product(input, currentVal, type);
						disable_btn_product($(this), input);
					@endif

					// flg = 0;
					// show_tooltip(input, flg);
				} 
				if(parseInt(input.val()) == input.attr('min')) {
					$(this).attr('disabled', true);
				}

			} else if(type == 'plus') {

				if(currentVal < input.attr('max')) {
					@if (Route::is('frontend.cart.index'))
						qty_plus(input, currentVal, lab_total, type);
						qty_plus_mobile(input_mobile, currentVal, lab_total_mobile, type);
						disable_btn($(this), input, vid, cid);

						varian_qty = currentVal+1;
					@else
						qty_plus_product(input, currentVal, type);
						disable_btn_product($(this), input);
					@endif

					// flg = 0;
					// show_tooltip(input, flg);
				}
				if(parseInt(input.val()) == input.attr('max')) {
					$(this).attr('disabled', true);
					// flg = 1;
					// show_tooltip(input, flg);
				}
			}

			@if (Route::is('frontend.cart.index'))
				send_ajax_update(varian_qty, action_update);
			@endif
		} else {
			input.val(0);
		}
	});
	$('.btn-number').mouseleave(function(e){
		e.preventDefault();
		fieldName 				= $(this).attr('data-field');

		@if (Route::is('frontend.cart.index'))
			var input 			= $(this).parent().parent().find('.input-number').attr('data-name', fieldName);
		@else
			var input 			= $(this).parent().find('.input-number').attr('data-name', fieldName);
		@endif

		// if (flg==1) {
		// 	flg = 0;
		// 	show_tooltip(input, flg);
		// }
	});
	$('.input-number').focusin(function(){
	   $(this).attr('data-oldValue', $(this).val());
	});

	$(".input-number").keydown(function (e) {
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
			 // Allow: Ctrl+A
			(e.keyCode == 65 && e.ctrlKey === true) || 
			 // Allow: home, end, left, right
			(e.keyCode >= 35 && e.keyCode <= 39)) {
				 // let it happen, don't do anything
				 return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	});

	// FOR MOBILE
	$('.btn-number-mobile').click(function(e){
		e.preventDefault();
		
		fieldName = $(this).attr('data-field');
		type      = $(this).attr('data-type');

		var cid 				= $(this).attr('data-cid');
		var vid 				= $(this).attr('data-vid');

		var list_cart 			= $('.list-vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');

		var input_mobile 		= $(this).parent().siblings().find('.input-number-mobile').attr('data-name', fieldName);
		var lab_total_mobile 	= input_mobile.parent().parent().parent().parent().parent().find('.label-total-mobile');

		var input 				= list_cart.find('.input-number[data-name="'+fieldName+'"]');
		var lab_total  			= input.parent().parent().parent().parent().parent().parent().find('.label-total');

		var action_update 		= $(this).attr('data-action-update');
		var varian_qty 			= 0;

		var currentVal = parseInt(input_mobile.val());

		if (!isNaN(currentVal)) {
			if(type == 'minus') {
				if(currentVal > input_mobile.attr('min')) {
					qty_minus_mobile(input_mobile, currentVal, lab_total_mobile, type);
					qty_minus(input, currentVal, lab_total, type);
					disable_btn($(this), input_mobile, vid, cid);

					varian_qty = currentVal-1;
				} 
				if(parseInt(input_mobile.val()) == input_mobile.attr('min')) {
					$(this).attr('disabled', true);
				}

			} else if(type == 'plus') {

				if(currentVal < input_mobile.attr('max')) {
					qty_plus_mobile(input_mobile, currentVal, lab_total_mobile, type);
					qty_plus(input, currentVal, lab_total, type);
					disable_btn($(this), input_mobile, vid, cid);	

					varian_qty = currentVal+1;
				}
				if(parseInt(input_mobile.val()) == input_mobile.attr('max')) {
					$(this).attr('disabled', true);
					// flg = 1;
					// show_tooltip(input_mobile, flg);
				}
			}
			send_ajax_update(varian_qty, action_update);
		} else {
			input_mobile.val(0);
		}
	});
	$('.input-number-mobile').focusin(function(){
	   $(this).attr('data-oldValue', $(this).val());
	});
	
	$(".input-number-mobile").keydown(function (e) {
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
			 // Allow: Ctrl+A
			(e.keyCode == 65 && e.ctrlKey === true) || 
			 // Allow: home, end, left, right
			(e.keyCode >= 35 && e.keyCode <= 39)) {
				 // let it happen, don't do anything
				 return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	});

	//===== IN PRODUCT =====
	function disable_btn_product(e, t) 
	{		
		minValue =  parseInt($(t).attr('min'));
		maxValue =  parseInt($(t).attr('max'));
		valueCurrent = parseInt($(t).val());
			
		name = $(e).attr('data-field');

		if(valueCurrent > minValue) {
			$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
			$(".btn-number[data-type='minus'][data-field='"+name+"']").attr('disabled', true);
			// $(e).val($(this).attr('data-oldValue'));
		}
		if(valueCurrent < maxValue) {
			flg = 0;
			show_tooltip(t, flg);
			// show_tooltip(list_cart.find('.input-number-mobile[data-field="'+name+'"]'), flg);

			$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
			flg = 1;
			show_tooltip(t, flg);
			// show_tooltip(list_cart.find('.input-number-mobile[data-field="'+name+'"]'), flg);

			$(".btn-number[data-type='plus'][data-field='"+name+"']").attr('disabled', true);
			// $(this).val($(this).attr('data-oldValue'));
		}
	}
	function qty_plus_product(e, current_val, type)
	{
		var old_value = 0;
		var sumtotal = 0;

		old_value = current_val;
		e.val(current_val + 1).change();
		total_product(e, type);
		sumtotal += sumtotal_product(e);

		$('.price-all-product').text('IDR '+number_format(sumtotal))
		e.attr('data-oldValue', old_value);
	}

	function total_product(e, flag)
	{
		var qty = parseInt(e.val());
		var price = parseInt(e.attr('data-price'));
		var discount = parseInt(e.attr('data-discount'));
		var total_price_qty = 0;
		
		total_price_qty = (price-discount)*qty;
		e.attr('data-total', total_price_qty);
	}

	function sumtotal_product(e)
	{
		var total_all = 0;

		$('.input-number').each( function() {
			var temp = parseInt($(this).attr('data-total'));
			total_all += temp;
		});
		return total_all;
	}

	function qty_minus_product(e, current_val, type)
	{
		var old_value = 0;
		var sumtotal = 0;

		old_value = current_val;
		e.val(current_val - 1).change();
		total_product(e, type);
		sumtotal -= sumtotal_product(e);

		$('.price-all-product').text('IDR '+number_format(sumtotal))
		e.attr('data-oldValue', old_value);
	}

	//===== STOP IN PRODUCT =====

	//===== IN CART ======
	function disable_btn(e, t, vid, cid)
	{
		minValue =  parseInt($(t).attr('min'));
		maxValue =  parseInt($(t).attr('max'));
		valueCurrent = parseInt($(t).val());
		var list_cart = $('.list-vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');
		var list_cart_mobile = $('.list-vid-mobile[data-vid="'+vid+'"][data-cid="'+cid+'"]');
			
		name = $(e).attr('data-field');

		if(valueCurrent > minValue) {
			list_cart_mobile.find(".btn-number-mobile[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
			list_cart.find(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
			list_cart_mobile.find(".btn-number-mobile[data-type='minus'][data-field='"+name+"']").attr('disabled', true);
			list_cart.find(".btn-number[data-type='minus'][data-field='"+name+"']").attr('disabled', true);
			// $(e).val($(this).attr('data-oldValue'));
		}
		if(valueCurrent < maxValue) {
			flg = 0;
			show_tooltip(t, flg);
			// show_tooltip(list_cart.find('.input-number-mobile[data-field="'+name+'"]'), flg);

			list_cart_mobile.find(".btn-number-mobile[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
			list_cart.find(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
			flg = 1;
			show_tooltip(t, flg);
			// show_tooltip(list_cart.find('.input-number-mobile[data-field="'+name+'"]'), flg);

			list_cart_mobile.find(".btn-number-mobile[data-type='plus'][data-field='"+name+"']").attr('disabled', true);
			list_cart.find(".btn-number[data-type='plus'][data-field='"+name+"']").attr('disabled', true);
			// $(this).val($(this).attr('data-oldValue'));
		}	
	}

	function qty_plus_mobile(e, current_val, lab_total_mobile, type)
	{
		var old_value = 0;
		var sumtotal_mobile = 0;

		old_value = current_val;
		e.val(current_val + 1).change();
		total_mobile(e, type);
		sumtotal_mobile += sum_total_mobile(e);
		lab_total_mobile.attr('data-subtotal', sumtotal_mobile);
		lab_total_mobile.text('IDR '+number_format(sumtotal_mobile));
		e.attr('data-oldValue', old_value);
		grand_total_mobile();
	}

	function qty_minus_mobile(e, current_val, lab_total_mobile, type) {
		var old_value = 0;
		var sumtotal_mobile = 0;

		old_value = current_val;
		e.val(current_val - 1).change();
		total_mobile(e, type);
		sumtotal_mobile += sum_total_mobile(e);
		lab_total_mobile.attr('data-subtotal', sumtotal_mobile);
		lab_total_mobile.text('IDR '+number_format(sumtotal_mobile));
		e.attr('data-oldValue', old_value);
		grand_total_mobile();
	}

	function total_mobile(e, flag)
	{
		var qty = parseInt(e.val());
		var price = parseInt(e.attr('data-price'));
		var discount = parseInt(e.attr('data-discount'));
		var total_price_qty = 0;
		
		total_price_qty = (price-discount)*qty;
		e.attr('data-total', total_price_qty);
	}

	function sum_total_mobile(e)
	{
		var cid = e.attr('data-cid');
		var total_all = 0;

		$('.input-number-mobile[data-cid="'+cid+'"]').each( function() {
			var temp = parseInt($(this).attr('data-total'));
			total_all += temp;
		});
		return total_all;
	}

	function grand_total_mobile() 
	{
		var grandtotal = 0;
		$('.label-total-mobile').each( function() {
			var temp = parseInt($(this).attr('data-subtotal'));
			grandtotal += temp;
		});
		$('.grand-total-mobile').text('IDR ' +number_format(grandtotal));
	}

	function delete_varian_mobile(e, lab_total_mobile)
	{
		var sumtotal_mobile = 0;
		sumtotal_mobile += sum_total_mobile(e);
		lab_total_mobile.attr('data-subtotal', sumtotal_mobile);
		lab_total_mobile.text('IDR '+number_format(sumtotal_mobile));
		grand_total_mobile();
	}

	function qty_plus(e, current_val, lab_total, type)
	{
		var old_value = 0;
		var total_item = 0;

		old_value = current_val;
		e.val(current_val + 1).change();
		total_item = total(e, type);
		lab_total.attr('data-total', total_item);
		lab_total.find('span').text('IDR '+number_format(total_item));
		e.attr('data-oldValue', old_value);
		grand_total();
	}

	function qty_minus(e, current_val, lab_total, type)
	{
		var old_value = 0;
		var total_item = 0;

		old_value = current_val;
		e.val(current_val - 1).change();
		total_item = total(e, type);
		lab_total.attr('data-total', total_item);
		lab_total.find('span').text('IDR '+number_format(total_item));
		e.attr('data-oldValue', old_value);
		grand_total();
	}

	function total(e, flag)
	{
		var qty = parseInt(e.val());
		var price = parseInt(e.attr('data-price'));
		var discount = parseInt(e.attr('data-discount'));
		var total_price_qty = 0;
		
		total_price_qty = (price-discount)*qty;
		e.attr('data-total', total_price_qty);

		return total_price_qty;
	}

	function sum_total(e)
	{
		var cid = e.attr('data-cid');
		var total_all = 0;

		$('.input-number[data-cid="'+cid+'"]').each( function() {
			var temp = parseInt($(this).attr('data-total'));
			total_all += temp;
		});
		return total_all;
	}

	function grand_total()
	{
		var grandtotal = 0;
		$('.label-total').each( function() {
			var temp = parseInt($(this).attr('data-total'));
			grandtotal += temp;
		});
		$('.grand-total').html('<strong>IDR ' +number_format(grandtotal)+'</strong>');	
	}

	function send_ajax_update(item_qty, action)
	{
		$.ajax({
			url: action,
			type: 'POST',
			dataType:"json",
			async: true,
			data: {qty: item_qty},
			success: function(result) {
				// console.log(result);
			}
		});
	}

	// Add to Cart
	$('.addto-cart').on('click', function(e) {
		var pvarians 	= [];
		var pqty 		= [];
		var fcart 		= $('.form-addtocart');
		var pslug 		= $('.pslug').val();
		var pname 		= $('.pname').val();
		var count_cart 	= 0;
		var check 		= 0;


		fcart.attr('action', 'javascript:void(0);');
		$('.pqty').each( function() {
			var value = parseInt($(this).val());
			pqty.push($(this).val());
			check += value;
		});
			
		if (check===0) {
			flg = 1;
			$('.input-number').tooltip({trigger: 'manual', title: 'Isi salah satu kuantitas'}).tooltip('show');
			setTimeout( function() {
				$('.input-number').tooltip('hide');
			}, 2500);
			
			return false;
		}
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
				count_cart 	= Object.keys(result.carts).length; 
				$('.addto-cart').val('ADD TO CART');
				$('.ico-cart').find('span').html(count_cart);

					$.each(result.carts, function(k, v) {
						$.each(v.varians, function(k2, v2) {
							if (v2.message!=='') {
								flg = 1;
								show_tooltip($('.input-number').find('[data-id="'+v2.varian_id+'"]'), flg);
							}
						});
					});
				
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
		var cid 	= $(this).data('cid');
		var vid 	= $(this).data('vid');
		var row 	= $(this).parent().parent().parent().parent();
		
		$.ajax({
			url: '{{ route('frontend.cart.destroy') }}',
			type: 'POST',
			dataType:"json",
			data: { cid: cid },
			success: function(result) {
				count_cart = Object.keys(result.carts).length;
				if (count_cart>=1) {
					var list_cart = $('.list-vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');
					var list_cart_mobile = $('.list-vid-mobile[data-vid="'+vid+'"][data-cid="'+cid+'"]');

					

					list_cart.parent().parent().remove();
					list_cart_mobile.parent().parent().parent().parent().remove();

					grand_total();
					grand_total_mobile();

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
				else
				{
					delete_item_last();
				}

				$('.ico-cart').find('span').html(count_cart);
			}

		});
	});

	$('.btn-delete-varian').on('click', function() {
		var row 		= $(this).parent().parent();
		var flag 		= row.attr('data-get-flag');
		var cid 		= $(this).data('cid');
		var vid 		= $(this).data('vid');
		var fieldName	= $(this).data('field');

		$.ajax({
			url: '{{ route('frontend.cart.destroy') }}',
			type: 'POST',
			dataType:"json",
			data: {cid: cid, vid: vid},
			success: function(result) {
				count_cart = Object.keys(result.carts).length;
				check_varians = result.carts[cid];

				if (count_cart>=1) {
					var list_cart = $('.list-vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');
					var list_cart_mobile = $('.list-vid-mobile[data-vid="'+vid+'"][data-cid="'+cid+'"]');
					var inputmobile = list_cart_mobile.find('.input-number-mobile[data-name="'+fieldName+'"]');
					var lab_total_mobile = inputmobile.parent().parent().parent().parent().parent().find('.label-total-mobile');

					if (typeof check_varians != 'undefined')
					{
						list_cart.remove();
						list_cart_mobile.remove();
					}
					else
					{
						list_cart.parent().parent().remove();
						list_cart_mobile.parent().parent().parent().parent().remove();
					}

					grand_total();
					delete_varian_mobile(inputmobile, lab_total_mobile);
				}

				else {
					$('.ico-cart').find('span').html(0);
					delete_item_last();
				}

				$.ajax({
					url: '{{ route('frontend.cart.listBasket.ajax') }}',
					beforeSend: function() {
						$('chart-dropdown').html("<img src='/Balin/web/image/loading.gif'/>");
					},
					success: function(msg) {
						$('.chart-dropdown').html(msg);
					}
				});
				$('.ico-cart').find('span').html(count_cart);
			}
		});

	});

	function delete_item_last()
	{
		var page 	 = '';	
		$('.chart-footer').remove();
		$('.chart-item').remove();
		$('.chart-topLine').remove();
		page += '<div class="row chart-item"> \
					<div class="col-md-12 col-sm-12 col-xs-12"> \
						<h4 class="text-center">Tidak ada item di cart</h4> \
					</div> \
				</div> \
				<div class="row chart-topLine"></div>';
		$('.chart-div').append(page);
		$('.empty-cart').remove();
		$('.empty-cart-mobile').remove();
		$('.checkout').remove();
	}

	// ======= STOP IN CART =======

	function show_tooltip(input, flg)
	{
		if (flg == 1) {
			$(input).tooltip({delay: { "show": 1000, "hide": 1000 }, title: 'Maaf stock barang size ini hanya tersedia ' +input.attr('max')}).tooltip('show');
			setTimeout( function() {
				$(input).tooltip('hide');
			}, 2000);
		} else {
			setTimeout( function() {
				$(input).tooltip('hide');
			}, 2500);
		}
	}

	function number_format(number, decimals, dec_point, thousands_sep) {
	  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

	  var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + (Math.round(n * k) / k).toFixed(prec);
			};

	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}

		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}

</script>