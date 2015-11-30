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
		console.log('yes');
	});

	$('.choice_address').click( function() {
	    var options = $(this).find("option");
	    var count = options.length;
	    if (typeof(count) === "undefined" || count < 2)
	    {
	        $('.new-address').removeClass('new-address-hide');
			$('.new-address').addClass('new-address-show');

			jQuery('#zipcode').on('input propertychange paste', function() {
				GetShippingCost( {'zipcode' : $( "#zipcode" ).val()} );
			});
	    }
	});

	$('.choice_address').on('change', function() {
		var val = $(this).val();
		if (val == 0) {
			$('.new-address').removeClass('new-address-hide');
			$('.new-address').addClass('new-address-show');

			jQuery('#zipcode').on('input propertychange paste', function() {
				GetShippingCost( {'zipcode' : $( "#zipcode" ).val()} );
			});			
		}
		else {
			$('.new-address').removeClass('new-address-show');
			$('.new-address').addClass('new-address-hide');
			GetShippingCost( {'address' : $( "#address_id" ).val()} );
		}
	});

	$('button.voucher-desktop').click( function() {
		inp = $('input.voucher-desktop');
		voucher = get_voucher(inp);
		show_voucher(voucher, inp);
	});

	$('button.voucher-tablet').click( function() {
		inp = $('input.voucher-tablet');
		voucher = get_voucher(inp);
		show_voucher(voucher, inp);
	});

	$('button.voucher-mobile').click( function() {
		inp = $('input.voucher-mobile');
		voucher = get_voucher(inp);
		show_voucher(voucher, inp);
	});

	function setModalMaxHeight(element) {
		this.$element     = $(element);
		var dialogMargin  = $(window).width() > 767 ? 62 : 22;
		var contentHeight = $(window).height() - dialogMargin;
		var headerHeight  = this.$element.find('.modal-header').outerHeight() || 2;
		var footerHeight  = this.$element.find('.modal-footer').outerHeight() || 2;
		var maxHeight     = contentHeight - (headerHeight + footerHeight);

		this.$element.find('.modal-content').css({
			'overflow': 'hidden'
		});

		this.$element.find('.modal-body').css({
			'max-height': maxHeight,
			'overflow-y': 'auto'
		});
	}

	$('.modal').on('show.bs.modal', function() {
		$(this).show();
		setModalMaxHeight(this);
	});

	$(window).resize(function() {
		if ($('.modal.in').length != 0) {
			setModalMaxHeight($('.modal.in'));
		}
	});

   function GetShippingCost(e){
		$.post( "{{route('frontend.any.zipcode')}}", e)
			.done(function( data ) {
			$(".shippingcost").text(data);
			countSubTotal();
		});        
    };

    function countSubTotal(){
    	var to = $.trim($("#total").text().replace(/\./g, '')).substring(4);
    	var sc = ($(".shippingcost").first().text().replace(/\./g, '')).substring(4);
    	var yp = ($("#point").text().replace(/\./g, '')).substring(4);
    	to = parseInt(to);
    	sc = parseInt(sc);
    	yp = parseInt(yp);

		if(isNaN(sc)) {
			sc = 0;
		}

    	var st = 'IDR ' + (to + sc - yp);

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
		console.log(e);
		if (e.type=='success')
		{
			panel_voucher = $('.panel-form-voucher');
			panel_voucher_device = $('.panel-form-voucher-device');

			modal_notif = $('.modal-notif');
			modal_notif.find('.title').children().html('');
			modal_notif.find('.content').html(e.msg);

			set_voucher_id(p);

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

</script>