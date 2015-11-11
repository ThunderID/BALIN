{!! HTML::style('Balin/web/plugin/revolution-slider/css/style.css') !!}
{!! HTML::style('Balin/web/plugin/revolution-slider/css/navstylechange.css') !!}
{!! HTML::style('Balin/web/plugin/revolution-slider/rs-plugin/css/settings.css') !!}
{!! HTML::script('Balin/web/plugin/revolution-slider/rs-plugin/js/jquery.themepunch.plugins.min.js') !!}
{!! HTML::script('Balin/web/plugin/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js') !!}

<script type="text/javascript">

	var revapi;

	jQuery(document).ready(function() {

		   revapi = jQuery('.tp-banner').revolution(
			{
				delay:15000,
				startwidth:1170,
				startheight:500,
				hideThumbs:10,
				fullWidth:"off",
				fullScreen:"on",
				fullScreenOffsetContainer: ""
			});

	});	//ready

</script>