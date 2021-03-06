{!! HTML::style('Balin/admin/plugin/jquery-step/jquery.steps.css') !!}
{!! HTML::script('Balin/admin/plugin/jquery-step/jquery.steps.min.js') !!}

<script>
	$('#create-transaction').steps({
		bodyTag: "fieldset",
		transitionEffect: "slideLeft",
		autoFocus: true,
		onInit: function (event, currentIndex) {
			resizeJquerySteps();
		},
		onContentLoaded: function (event, currentIndex) {
			resizeJquerySteps();
		},
		onStepChanged: function (event, currentIndex, priorIndex) {
			resizeJquerySteps();
		},
		onFinished: function (event, currentIndex) {
			$(this).submit();
		},
		onCanceled: function (event) {

		},
		labels: {
			finish: "Simpan",
			cancel: "Batal",
			next: "Lanjut",
			previous: "Sebelum"
		}
	});

	$('.wizard .content').animate({ height: $('.body.current').outerHeight() }, "slow");
	
	var form = $("#example-form");

	form.children("div").steps({
	    headerTag: "h3",
	    bodyTag: "fieldset",
	    transitionEffect: "slideLeft"
	});

	function resizeJquerySteps() {
		$('.wizard .content').animate({ height: $('.body.current').outerHeight() }, "slow");
	}

	$('.transaction-input-qty').on('change', function()
	{
		var qty = $(this).val();
		var price_jum = 0;
		var price = parseInt($(this).parent().parent().parent().find('.transaction-input-price').val());
		var discount = parseInt($(this).parent().parent().parent().find('.transaction-input-discount').val());

		price_jum = (price-discount)*qty;

		$(this).parent().parent().parent().find('.transaction-input-jum-price').val(price_jum);

	});
</script>