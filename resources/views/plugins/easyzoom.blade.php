{!! HTML::style('Balin/web/plugin/easyzoom/easyzoom.css') !!}
{!! HTML::script('Balin/web/plugin/easyzoom/easyzoom.js') !!}

<script>
	// Instantiate EasyZoom instances
	var $easyzoom = $('.easyzoom').easyZoom({loadingNotice:""});
	// Get an instance API
	var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

	$('.item').on('click', 'a', function(e) {
		var $this = $(this);
		
		e.preventDefault();

		// Use EasyZoom's `swap` method
		api1.swap($this.data('standard'), $this.attr('href'));
	});
</script>