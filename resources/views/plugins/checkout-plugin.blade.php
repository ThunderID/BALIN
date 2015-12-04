<script type="text/javascript">
	$( document ).ready(function() {
		<!-- pre load shipping cost -->
		if($('.choice_address').val == 0){
			GetShippingCost( {'zipcode' : $( "#zipcode" ).val()} );
		}else{
			GetShippingCost( {'address' : $( "#address_id" ).val()} );
		}

		countSubTotal();
	});

	$('choice_address').focusin( function() {
		// console.log('yes');
	});

	// $('.choice_address').click( function() {
	//     var options = $(this).find("option");
	//     var count = options.length;
	//     if (typeof(count) === "undefined" || count < 2)
	//     {
	//         $('.new-address').removeClass('new-address-hide');
	// 		$('.new-address').addClass('new-address-show');

	// 		jQuery('#zipcode').on('input propertychange paste', function() {
	// 			GetShippingCost( {'zipcode' : $( "#zipcode" ).val()} );
	// 		});
	//     }
	// });

	$('.choice_address').on('change', function() {
		var val = $(this).val();
		if (val == 0) {
			// $('.new-address').removeClass('new-address-hide');
			// $('.new-address').addClass('new-address-show');
			jQuery('#zipcode').on('input propertychange paste', function() {
				GetShippingCost( {'zipcode' : $( "#zipcode" ).val()} );
			});	
			ga = get_address($(this));
			parsing_address(ga);
		}
		else {
			// $('.new-address').removeClass('new-address-show');
			// $('.new-address').addClass('new-address-hide');

			GetShippingCost( {'address' : $( "#address_id" ).val()} );
			ga = get_address($(this));
			parsing_address(ga);
		}
	});

	$('.ch-zipcode').focusout( function() {
		val = $(this).val();
		GetShippingCost( {'zipcode' : $( "#zipcode" ).val()} );
	});

	$('button.voucher-desktop').click( function() {
		inp = $('input.voucher-desktop');
		voucher = get_voucher(inp);
		show_voucher(voucher, inp);
		countSubTotal();
	});

	$('button.voucher-tablet').click( function() {
		inp = $('input.voucher-tablet');
		voucher = get_voucher(inp);
		show_voucher(voucher, inp);
		countSubTotal();
	});

	$('button.voucher-mobile').click( function() {
		inp = $('input.voucher-mobile');
		voucher = get_voucher(inp);
		show_voucher(voucher, inp);
		countSubTotal();
	});

	// function setModalMaxHeight(element) {
	// 	this.$element     = $(element);
	// 	var dialogMargin  = $(window).width() > 767 ? 62 : 22;
	// 	var contentHeight = $(window).height() - dialogMargin;
	// 	var headerHeight  = this.$element.find('.modal-header').outerHeight() || 2;
	// 	var footerHeight  = this.$element.find('.modal-footer').outerHeight() || 2;
	// 	var maxHeight     = contentHeight - (headerHeight + footerHeight);

	// 	this.$element.find('.modal-content').css({
	// 		'overflow': 'hidden'
	// 	});

	// 	this.$element.find('.modal-body').css({
	// 		'max-height': maxHeight,
	// 		'overflow-y': 'auto'
	// 	});
	// }

	// $('.modal').on('show.bs.modal', function() {
	// 	$(this).show();
	// 	setModalMaxHeight(this);
	// });

	// $(window).resize(function() {
	// 	if ($('.modal.in').length != 0) {
	// 		setModalMaxHeight($('.modal.in'));
	// 	}
	// });

   function GetShippingCost(e){
   		cv = parseInt($('.shippingcost').attr('data-v'));
		$.post( "{{route('frontend.any.zipcode')}}", e)
			.done(function( data ) {
			if (cv==0) {
				$(".shippingcost").text(data);
			}
			$(".shippingcost").attr('data-s', (data.replace(/\./g, '')).substring(4));
			countSubTotal();
		});        
    };

    function countSubTotal(){
    	var to = $.trim($("#total").text().replace(/\./g, '')).substring(4);
    	var sc = ($(".shippingcost").first().text().replace(/\./g, '')).substring(4);
    	var yp = ($("#point").text().replace(/\./g, '')).substring(4);
    	uqnum = parseInt($('.uniquenumber').attr('data-unique'));
    	to = parseInt(to);
    	sc = parseInt(sc);
    	yp = parseInt(yp);

		if(isNaN(sc)) {
			sc = 0;
		}
		
    	var st = 'IDR ' + ((to + sc - yp)-uqnum);

		$(".subtotal").text(addCommas(st));

		function addCommas(nStr)
		{
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + '.' + '$2');
			}
			return x1 + x2;
		};
	}

	function get_voucher(e) {
		value = e.val();
		action = e.attr('data-action');
		var gv;
		
		$.ajax({
			url: action,
			type: 'post',
			dataType: 'json', 
			async: false,
			data: {voucher: value},
			beforeSend: function() {
				$('.loading-voucher').removeClass('hide');
			},
			success: function(data) {
				// $('.loading-voucher').addClass('hide');
				gv = data;
			}
		});

		return gv;
	}

	function show_voucher(e, p) 
	{
		if (e.type=='success')
		{
			panel_voucher = $('.panel-form-voucher');
			panel_voucher_device = $('.panel-form-voucher-device');

			modal_notif = $('.modal-notif');
			modal_notif.find('.title').children().html('');
			modal_notif.find('.content').html(e.msg);

			set_voucher_id(p);

			if (e.discount==true) {
				$('.shippingcost').text('IDR 0');
				$('.shippingcost').attr('data-s', 0);
				$('.shippingcost').attr('data-v', 1);
			}

			setTimeout( function() {
				$('.loading-voucher').addClass('hide');
				panel_voucher.html('<p class="m-b-none">'+e.msg+'</p>');
				panel_voucher_device.html('<p class="m-b-none text-center">'+e.msg+'</p>');
			}, 2000);

			$('#notif-window').modal('show');
		}
		else if (e.type=='error')
		{
			setTimeout( function() {
				$('.loading-voucher').addClass('hide');
			}, 1000);
			
			modal_notif = $('.modal-notif');
			modal_notif.find('.title').children().html('');
			modal_notif.find('.content').html(e.msg);

			p.addClass('error');

			$('#notif-window').modal('show');
		}
	}

	function set_voucher_id(e)
	{
		val = e.val();
		$('.voucher_code').val(val);
	}

	function get_address(e)
	{
		val = e.find(':selected').attr('value');
		ga = null;

		if (val!==0)
		{
			act = e.find(':selected').data('action');
			console.log(act);
			$.ajax({
				url: act,
				type: 'post',
				async: false,
				dataType: 'json',
				data: {id: val},
				success: function(data) {
					ga = data.address;
				}
			});
		}
		return ga;
	}

	function parsing_address(e)
	{
		ch_name = $('.ch-name');
		ch_address = $('.ch-address');
		ch_zipcode = $('.ch-zipcode');
		ch_phone = $('.ch-phone');

		if (typeof e !== 'undefined' && e != null) {
			ch_name.val(e[0].receiver_name);
			ch_address.val(e[0].address);
			ch_zipcode.val(e[0].zipcode);
			ch_phone.val(e[0].phone);
		} else {
			ch_name.val('');
			ch_address.val('');
			ch_zipcode.val('');
			ch_phone.val('');
		}
		countSubTotal();
	}
</script>