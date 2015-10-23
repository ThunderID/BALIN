{!! HTML::style('Balin/admin/plugin/dropzone/basic.css') !!}
{!! HTML::style('Balin/admin/plugin/dropzone/dropzone.css') !!}
{!! HTML::script('Balin/admin/plugin/dropzone/dropzone.js') !!}

<script>
	Dropzone.options.myAwesomeDropzone = {

		 autoProcessQueue: false,
		 uploadMultiple: true,
		 parallelUploads: 100,
		 maxFiles: 100,

		 // Dropzone settings
		 init: function() {
			  var myDropzone = this;

			  this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
					e.preventDefault();
					e.stopPropagation();
					myDropzone.processQueue();
			  });
			  this.on("sendingmultiple", function() {
			  });
			  this.on("successmultiple", function(files, response) {
			  });
			  this.on("errormultiple", function(files, response) {
			  });
		 }

	}
</script>
