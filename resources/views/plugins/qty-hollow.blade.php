<script>
	var tot_qty = 0;
	var gtotal = 0;

	@if (Route::is('frontend.cart.index'))
	@endif

	var tot_qty_mobile = 0;

	// FOR DESKTOP
	$('.btn-number').click(function(e){
		e.preventDefault();
		$(this).parent().parent().parent().attr('action', 'javascript:void(0);');

		fieldName = $(this).attr('data-field');
		type      = $(this).attr('data-type');
		// var input = $("input[name='"+fieldName+"']");
		@if (Route::is('frontend.cart.index'))
			var input 			= $(this).parent().parent().find('.input-number').attr('data-name', fieldName);
			var qty   			= parseInt($(this).attr('data-price'));
			var get_flag		= $(this).attr('data-get-flag');
			var cid 			= $(this).parent().parent().parent().find('.cid');
			var vid 			= $(this).parent().parent().parent().find('.vid');
			// var pqty 			= [];

			var pqty = $.map($(".pqty"), function(elt) { return elt.val;});
			// $('.pqty').each( function() {
			// 	pqty.push($(this).val());
			// });

			tot_qty 			= parseInt($(this).parent().parent().parent().parent().parent().parent().find('div[data-get-total="'+get_flag+'"]').attr('data-total'));	
		@else
			var input 			= $(this).parent().find('.input-number').attr('data-name', fieldName);
			var qty   			= parseInt($('.tot_qty').data('price'));
		@endif
		var currentVal = parseInt(input.val());

		if (!isNaN(currentVal)) {
			if(type == 'minus') {
				if(currentVal > input.attr('min')) {
					input.val(currentVal - 1).change();
					tot_qty -= qty;

					@if (Route::is('frontend.cart.index'))
						$(this).parent().parent().parent().parent().parent().parent().find('div[data-get-total="'+get_flag+'"]').text('IDR '+number_format(tot_qty));
						$(this).parent().parent().parent().parent().parent().parent().find('div[data-get-total="'+get_flag+'"]').attr('data-total', tot_qty);
						// $(this).parent().parent().parent().parent().parent().parent().find('div[data-get-total="'+get_flag+'"]').trigger('change');
						// $('.label-total').text('IDR '+number_format(tot_qty));
						gtotal = grand_total();
						$('.label-total-all').html('<strong>IDR '+number_format(gtotal)+'</strong>');
					@else
						$('.tot_qty').text('IDR '+number_format(tot_qty));
					@endif
				} 
				if(parseInt(input.val()) == input.attr('min')) {
					$(this).attr('disabled', true);
				}

			} else if(type == 'plus') {

				if(currentVal < input.attr('max')) {
					input.val(currentVal + 1).change();
					tot_qty += qty;

					@if (Route::is('frontend.cart.index'))
						$(this).parent().parent().parent().parent().parent().parent().find('div[data-get-total="'+get_flag+'"]').text('IDR '+number_format(tot_qty));
						$(this).parent().parent().parent().parent().parent().parent().find('div[data-get-total="'+get_flag+'"]').attr('data-total', tot_qty);
						gtotal = grand_total();
						$('.label-total-all').html('<strong>IDR '+number_format(gtotal)+'</strong>');
					@else
						$('.tot_qty').text('IDR '+number_format(tot_qty));
					@endif
				}
				if(parseInt(input.val()) == input.attr('max')) {
					$(this).attr('disabled', true);
				}
			}

			@if (Route::is('frontend.cart.index'))
				// send_ajax_update(cid, vid, pqty);
			@endif
		} else {
			input.val(0);
		}
	});
	$('.input-number').focusin(function(){
	   $(this).attr('data-oldValue', $(this).val());
	});
	$('.input-number').change(function() {
		
		minValue =  parseInt($(this).attr('min'));
		maxValue =  parseInt($(this).attr('max'));
		valueCurrent = parseInt($(this).val());
		
		name = $(this).attr('data-name');
		if(valueCurrent >= minValue) {
			$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
		} else {
			alert('Sorry, the minimum value was reached');
			$(this).val($(this).data('oldValue'));
		}
		if(valueCurrent <= maxValue) {
			$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
		} else {
			alert('Sorry, the maximum value was reached');
			$(this).val($(this).data('oldValue'));
		}
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
		// var input = $("input[name='"+fieldName+"']");
		var input = $(this).parent().find('.input-number-mobile').attr('data-name', fieldName);
		var currentVal = parseInt(input.val());
		// var qty   = parseInt($('.tot_qty').data('price'));

		if (!isNaN(currentVal)) {
			if(type == 'minus') {
				if(currentVal > input.attr('min')) {
					input.val(currentVal - 1).change();
					// tot_qty -= qty;
					// $('.tot_qty').text('IDR '+number_format(tot_qty));
				} 
				if(parseInt(input.val()) == input.attr('min')) {
					$(this).attr('disabled', true);
				}

			} else if(type == 'plus') {

				if(currentVal < input.attr('max')) {
					input.val(currentVal + 1).change();
					// tot_qty += qty;
					// $('.tot_qty').text('IDR '+number_format(tot_qty));
				}
				if(parseInt(input.val()) == input.attr('max')) {
					$(this).attr('disabled', true);
				}
			}
		} else {
			input.val(0);
		}
	});
	$('.input-number-mobile').focusin(function(){
	   $(this).data('oldValue', $(this).val());
	});
	$('.input-number-mobile').change(function() {
		
		minValue =  parseInt($(this).attr('min'));
		maxValue =  parseInt($(this).attr('max'));
		valueCurrent = parseInt($(this).val());
		
		name = $(this).attr('data-name');
		if(valueCurrent >= minValue) {
			$(".btn-number-mobile[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
		} else {
			alert('Sorry, the minimum value was reached');
			$(this).val($(this).data('oldValue'));
		}
		if(valueCurrent <= maxValue) {
			$(".btn-number-mobile[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
		} else {
			alert('Sorry, the maximum value was reached');
			$(this).val($(this).data('oldValue'));
		}
		
		
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

	function grand_total()
	{
		var tot = 0;
		$('.label-total').each( function() {
			tot += parseInt($(this).attr('data-total'));
		});

		return tot;
	}

	function send_ajax_update(cid, vid, pqty)
	{
		$.ajax({
			url: "{{ route('frontend.cart.update', ['cid' => "+cid+", 'vid' => "+vid+"]) }}",
			type: 'POST',
			dataType:"json",
			async: true,
			data: {qty: pqty},
			success: function(result) {
				// console.log(result);
			}
		});
	}
</script>