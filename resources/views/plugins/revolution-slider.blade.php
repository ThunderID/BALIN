{!! HTML::style('Balin/web/plugin/revolution-slider/css/style.css', 'secure' => true) !!}
{!! HTML::style('Balin/web/plugin/revolution-slider/css/navstylechange.css', 'secure' => true) !!}
{!! HTML::style('Balin/web/plugin/revolution-slider/rs-plugin/css/settings.css', 'secure' => true) !!}
{!! HTML::script('Balin/web/plugin/revolution-slider/rs-plugin/js/jquery.themepunch.plugins.min.js') !!}
{!! HTML::script('Balin/web/plugin/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js') !!}

<script type="text/javascript">

	var revapi;

	jQuery(document).ready(function() {

		   revapi = jQuery('.tp-banner').revolution(
			{
				delay:6000,
				startwidth:1170,
				startheight:500,
				hideThumbs:10,
				fullWidth:"off",
				fullScreen:"on",
				fullScreenOffsetContainer: ".page-header",
				touchenabled:"on",
				navigationType:"bullet",
				soloArrowLeftHOffset:80,
				soloArrowRightHOffset:80
			});

	});	//ready

</script>