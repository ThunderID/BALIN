{!! HTML::style('Balin/web/plugin/owlCarousel/assets/owl.carousel.css') !!}
{!! HTML::script('Balin/web/plugin/owlCarousel/owl.carousel.js') !!}

<script>
	// $(document).ready(function(){
	//   $(".owl-carousel").owlCarousel();
	// });

	$('.owl-carousel').owlCarousel({
	    loop:true,
	    margin:10,
	    responsiveClass:true,
	    nav: true,
	    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
	    responsive:{
	        0:{
	            items:1,
	            nav:true
	        },
	        600:{
	            items:3,
	            nav:true
	        },
	        1000:{
	            items:5,
	            nav:true,
	            loop:false
	        }
	    }
	})

	$('.backend-owl-carousel').owlCarousel({
	    loop:true,
	    margin:10,
	    responsiveClass:true,
	    lazyLoad: true,
	    navText: ['<p class="hidden" id="car-btn-prev">prev</p>', '<p class="hidden" id="car-btn-next">next</p>' ],
	    responsive:{
	        0:{
	            items:1,
	            nav:true
	        },
	        600:{
	            items:3,
	            nav:false
	        },
	        1000:{
	            items:4,
	            nav:true,
	            loop:false
	        }
	    }
	})	
</script>